<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor\DTO;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class Item
 *
 * @method mixed getItem();
 * @method string getName();
 */
class Item
{
    use RichModelTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $item;

    /**
     * Item constructor.
     *
     * @param string $name
     * @param mixed  $item
     */
    public function __construct(string $name, $item)
    {
        $this->name = $name;
        $this->item = $item;
    }
}
