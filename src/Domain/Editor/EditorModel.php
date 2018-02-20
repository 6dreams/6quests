<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class EditorModel
 *
 * @method self addField(EditorField $field);
 * @method string getModel();
 * @method EditorField[] getFields();
 *
 */
class EditorModel
{
    use RichModelTrait;

    protected static $richAccessMap = [
        'field' => 'fields'
    ];

    /**
     * @var EditorField[]
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $model;

    /**
     * EditorModel constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->model = $name;
    }
}
