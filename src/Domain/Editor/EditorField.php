<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Editor\DTO\RelationField;

/**
 * Class EditorField
 *
 * @method string getName();
 * @method int getType();
 * @method int getDisplay();
 * @method string getTitle();
 * @method string getCustomTemplate();
 * @method self setCustomTemplate(string $info);
 * @method self setValues(array $args);
 * @method RelationField getRelation();
 * @method self setRelation(RelationField $ref);
 *
 */
class EditorField
{
    use RichModelTrait;

    // типы полей.
    public const TYPE_INDEX     = 0;
    public const TYPE_INPUT     = 1;
    public const TYPE_SELECT    = 2;
    public const TYPE_DB_SELECT = 3;

    public const DISPLAY_EDIT = 0;
    public const DISPLAY_LIST = 1;
    public const DISPLAY_ALL  = 3;

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
    protected $display;

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
     * @var RelationField
     */
    protected $relation;

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
        $this->display = self::DISPLAY_ALL;
    }

    /**
     * Отобразить в списке.
     *
     * @param int $state
     *
     * @return EditorField
     */
    public function setDisplay(int $state): self
    {
        $this->display = $state;

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
     * Название сеттера в модели.
     *
     * @return string
     */
    public function getSetterName(): string
    {
        return 'set' . ucfirst($this->name);
    }

    /**
     * Значение списка.
     *
     * @param int|string $value
     *
     * @return mixed|string
     */
    public function getNameOf($value)
    {
        return $this->values[$value] ?? '(broken)';
    }

    /**
     * @return bool
     */
    public function isShowInEdit(): bool
    {
        return $this->display === self::DISPLAY_ALL || $this->display === self::DISPLAY_EDIT;
    }

    /**
     * @return bool
     */
    public function isShowInList(): bool
    {
        return $this->display === self::DISPLAY_ALL || $this->display === self::DISPLAY_LIST;
    }
}
