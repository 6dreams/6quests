<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor\DTO;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class ListItems
 *
 * @method string getName();
 * @method array getItems();
 */
class ListItems
{
    use RichModelTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $items;

    /**
     * ListItems constructor.
     *
     * @param string $fcqn
     * @param array  $items
     */
    public function __construct(string $fcqn, array $items)
    {
        $this->name = $fcqn;
        $this->items = $items;
    }
}
