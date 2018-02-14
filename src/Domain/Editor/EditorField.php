<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class EditorField
 *
 * @method string getName();
 * @method int getType();
 * @method bool isInList();
 * @method string getTitle();
 * @method string getCustomTemplate();
 * @method self setCustomTemplate(string $info);
 * @method self setValues(array $args);
 *
 * @package SixQuests\Domain\Editor
 */
class EditorField
{
    use RichModelTrait;

    // типы полей.
    public const TYPE_INDEX     = 0;
    public const TYPE_INPUT     = 1;
    public const TYPE_SELECT    = 2;
    public const TYPE_DB_SELECT = 3;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var bool
     */
    protected $inList;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string
     */
    protected $customTemplate;

    /**
     * @var array
     */
    private $values = [];

    /**
     * EditorField constructor.
     *
     * @param string      $name
     * @param int         $type
     * @param null|string $title
     */
    public function __construct(string $name, int $type, ?string $title = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->title = $title ?? $name;
        $this->inList = true;
    }

    /**
     * Отобразить в списке.
     *
     * @param bool $state
     * @return EditorField
     */
    public function setVisibleInList(bool $state): self
    {
        $this->inList = $state;

        return $this;
    }

    /**
     * Название свойства модели.
     *
     * @return string
     */
    public function getPropertyName(): string
    {
        return 'get' . ucfirst($this->name);
    }

    /**
     * Значение списка.
     *
     * @param int|string $value
     * @return mixed|string
     */
    public function getNameOf($value)
    {
        return $this->values[$value] ?? '(broken)';
    }
}
