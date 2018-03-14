<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor\DTO;

/**
 * Class Paginator
 */
class Paginator
{
    /**
     * @var int
     */
    private $current;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $limit;

    /**
     * Paginator constructor.
     *
     * @param int $current
     * @param int $count
     * @param int $limit
     */
    public function __construct(int $current, int $count, int $limit)
    {
        $this->current = $current;
        $this->count = $count;
        $this->limit = $limit;
    }

    /**
     * Отображать?
     *
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->count > $this->limit;
    }

    /**
     * Получить итератор для создания пагинации.
     *
     * @return \Generator|null
     */
    public function getIterator(): ?\Generator
    {
        for ($i = 0; $i < $this->count / $this->limit; $i++) {
            yield [
                'number' => $i + 1,
                'offset' => $i * $this->limit
            ];
        }
    }
}
