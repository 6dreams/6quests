<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Database\Driver;

/**
 * Class AbstractRepository
 * @package SixQuests\Domain\Repository
 */
abstract class AbstractRepository
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @var string
     */
    protected static $table = '';

    /**
     * AbstractRepository constructor.
     *
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Получить название таблицы учитывая префикс.
     *
     * @return string
     */
    protected function getTable(): string
    {
        return $this->driver->getPrefix() . static::$table;
    }

    /**
     * Получить название класса который будет результатом.
     *
     * @param null|string $model
     * @return string
     */
    private function getModel(?string $model): string
    {
        return $model ?? $this->getDefaultModel();
    }

    /**
     * Получить результаты.
     *
     * @param string      $query
     * @param array       $args
     * @param null|string $model
     * @return array|mixed
     */
    protected function getResults(string $query, array $args = [], ?string $model = null)
    {
        return $this->driver->executeFind($this->getModel($model), str_replace('~table', $this->getTable(), $query), $args);
    }

    /**
     * Получить первый результат.
     *
     * @param string      $query
     * @param array       $args
     * @param null|string $model
     * @return mixed
     */
    protected function getResult(string $query, array $args = [], ?string $model = null)
    {
        $results = $this->getResults($query, $args, $model);

        return \array_shift($results);
    }

    /**
     * Стандартный класс, который обслуживает репозиторий.
     *
     * @return string
     */
    abstract protected function getDefaultModel(): string;
}
