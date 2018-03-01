<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Database\Driver;
use SixQuests\Database\Exception\NotSupportedModelException;
use SixQuests\Domain\Utility\Utils;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @var array метатаблица!
     */
    private $modelMetaTable = [];

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
     * Получить сущность по ID.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->getResult('SELECT * FROM ~table WHERE id=:id', ['id' => $id]);
    }

    /**
     * Обновить или создать модель в базе.
     *
     * @param mixed $model
     *
     * @return bool
     */
    public function upsert($model): bool
    {
        try {
            $this->driver->executeUpsert($model);
        } catch (NotSupportedModelException $e) {
            return false;
        }

        return true;
    }

    /**
     * Получить результаты.
     *
     * @param string      $query
     * @param array       $args
     * @param null|string $model
     *
     * @return array|mixed
     */
    protected function getResults(string $query, array $args = [], ?string $model = null)
    {
        $model = $this->getModel($model);

        $replace = $this->getMetaTable($model);
        $replace['&'] = $this->driver->getPrefix();

        return $this->driver->executeFind(
            $model,
            \str_replace(['~table', '~fields', '&'], $replace, $query),
            $args
        );
    }

    /**
     * Получить первый результат.
     *
     * @param string      $query
     * @param array       $args
     * @param null|string $model
     *
     * @return mixed
     */
    protected function getResult(string $query, array $args = [], ?string $model = null)
    {
        $results = $this->getResults($query, $args, $model);

        return \array_shift($results);
    }

    /**
     * Получить название таблицы учитывая префикс.
     *
     * @param string $model
     *
     * @return string
     */
    protected function getTable(string $model): string
    {
        return '`' . $this->driver->getPrefix() . Utils::constant($model, 'TABLE') . '`';
    }

    /**
     * Стандартный класс, который обслуживает репозиторий.
     *
     * @return string
     */
    abstract protected function getDefaultModel(): string;

    /**
     * Получить название класса который будет результатом.
     *
     * @param null|string $model
     *
     * @return string
     */
    private function getModel(?string $model): string
    {
        return $model ?? $this->getDefaultModel();
    }

    /**
     * Получить описание модели.
     *
     * @param string $model
     *
     * @return array
     */
    private function getMetaTable(string $model): array
    {
        if (!\array_key_exists($model, $this->modelMetaTable)) {
            $table = $this->getTable($model);
            $fields = \implode(', ', \array_map(function (string $key) use ($table) {
                return \sprintf('%s.`%s`', $table, $key);
            }, Utils::constant($model, 'FIELDS')));

            $this->modelMetaTable[$model] = [$table, $fields];
        }

        return $this->modelMetaTable[$model];
    }
}
