<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor\DTO;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class ListItems
 *
 * @method string getName();
 * @method array getItems();
 * @method self setCount(int $amount);
 * @method self setCurrent(int $now);
 * @method self setLimit(int $limit);
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
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $current;

    /**
     * @var int
     */
    protected $limit;

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

    /**
     * Получить класс для рендеринга пагинации.
     *
     * @return Paginator
     */
    public function getPaginator(): Paginator
    {
        return new Paginator($this->current, $this->count, $this->limit);
    }
}
