<?php
declare(strict_types = 1);

namespace SixQuests\Database\DTO;

/**
 * Class Query
 */
class Query
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var array
     */
    private $arguments;

    /**
     * Query constructor.
     *
     * @param string $query
     * @param array  $arguments
     */
    public function __construct(string $query, array $arguments = [])
    {
        $this->query     = $query;
        $this->arguments = $arguments;
    }

    /**
     * Получение Query
     *
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Получение Arguments
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
