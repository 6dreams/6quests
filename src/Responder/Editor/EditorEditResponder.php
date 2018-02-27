<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Editor;

use SixQuests\Database\Driver;
use SixQuests\Domain\Editor\DTO\Item;
use SixQuests\Domain\Editor\EditorConfig;
use SixQuests\Domain\Editor\EditorField;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditorEditResponder
 */
class EditorEditResponder extends AbstractEditorResponder
{
    protected static $content = 'editor/editor_edit.html.twig';

    /**
     * @var Driver
     */
    private $driver;

    /**
     * EditorEditResponder constructor.
     *
     * @param \Twig_Environment $twig
     * @param Driver            $driver
     */
    public function __construct(\Twig_Environment $twig, Driver $driver)
    {
        parent::__construct($twig);
        $this->driver = $driver;
    }

    /**
     * @param EditorConfig $config
     * @param Item         $item
     *
     * @return Response
     */
    public function __invoke(EditorConfig $config, Item $item)
    {
        $fields = $config->getModel($item->getName())->getFields();

        foreach ($fields as $field) {
            // вот тут начинается костыльвания!
            $rel = $field->getRelation();
            if ($rel !== null && $field->getType() === EditorField::TYPE_DB_SELECT) {
                $items = $this->driver->executeFind(
                    $rel->getModel(),
                    \sprintf('SELECT * FROM %s%s', $this->driver->getPrefix(), $rel->getModel()::TABLE)
                );
                $ret = [];
                foreach ($items as $model) {
                    $ret[$model->{'getId'}()] = $model->{$rel->getField()}();
                }
                $field->setValues($ret);
            }
        }

        return $this
            ->prepare($config)
            ->setVariable('fields', $fields)
            ->setVariable('item', $item)
            ->setVariable('model', $config->getShortNameByFCQN($item->getName()))
            ->render();
    }
}
