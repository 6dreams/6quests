<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Editor;

use SixQuests\Database\Driver;
use SixQuests\Domain\Editor\DTO\ListItems;
use SixQuests\Domain\Editor\EditorConfig;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditorListResponder
 * @package SixQuests\Responder\Editor
 */
class EditorListResponder extends AbstractEditorResponder
{
    /**
     * @var string что рендерим.
     */
    protected static $content = 'editor/editor_list.html.twig';

    /**
     * @var Driver
     */
    private $driver;

    /**
     * AbstractEditorListResponder constructor.
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
     * @param ListItems    $list
     * @return Response
     */
    public function __invoke(EditorConfig $config, ListItems $list): Response
    {
        $fields = $config->getModel($list->getName())->getFields();

        return $this
            ->prepare($config)
            ->setVariable('heading', $fields)
            ->setVariable('items', $list->getItems())
            ->setVariable('model', $config->getShortNameByFCQN($list->getName()))
            ->render();
    }
}