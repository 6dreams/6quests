<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor\DTO;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class RelationField
 *
 * @method string getModel();
 * @method string getField();
 */
class RelationField
{
    use RichModelTrait;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $field;

    /**
     * RelationField constructor.
     *
     * @param string $model
     * @param string $field
     */
    public function __construct(string $model, string $field)
    {
        $this->model = $model;
        $this->field = $field;
    }
}
