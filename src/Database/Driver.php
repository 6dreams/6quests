<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixQuests\Database\Exception\NotSupportedModelException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Driver
 */
class Driver
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var Config
     */
    private $config;

    /**
     * Driver constructor.
     *
     * @param ContainerInterface $container
     * @param Hydrator           $hydrator
     */
    public function __construct(ContainerInterface $container, Hydrator $hydrator)
    {
        $this->config   = Config::fromParameters($container);
        $this->hydrator = $hydrator;
        $this->prefix   = $container->hasParameter('prefix') ? $container->getParameter('prefix') . '_' : '';
    }

    /**
     * Указать конфигурацию.
     *
     * @param Config $config
     * @param string $prefix
     *
     * @return Driver
     */
    public function setConfig(Config $config, string $prefix): self
    {
        $this->config = $config;
        $this->prefix = $prefix === '' ? '' : $prefix . '_';

        return $this;
    }

    /**
     * @param string $query
     */
    public function executeRawQuery(string $query): void
    {
        $this->connect();
        $this->pdo->exec($query);
    }

    /**
     * Запустить поиск по базе.
     *
     * @param string $model
     * @param string $query
     * @param array  $args
     *
     * @return array|mixed
     *
     * @throws NotSupportedModelException
     */
    public function executeFind(string $model, string $query, array $args = [])
    {
        $this->connect();

        $statement = $this->executeQuery($query, $args);

        $results = [];
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $result) {
            $results[] = $this->hydrator->hydrate($model, $result)->setDriver($this);
        }

        return $results;
    }

    /**
     * Создать или обновить модель в базе.
     *
     * @param mixed $model
     *
     * @throws NotSupportedModelException
     */
    public function executeUpsert($model): void
    {
        $this->connect();
        $query = $this->hydrator->dehydrate($model);
        $this->executeQuery(\str_replace('&&', $this->prefix, $query->getQuery()), $query->getArguments());
    }

    /**
     * Получение Prefix
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Преобразовать параметр запроса к базе в строку или число.
     *
     * @param mixed $value
     *
     * @return string|int
     */
    protected function processValue($value)
    {
        if (\is_int($value)) {
            return $value;
        }

        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        return $value;
    }

    /**
     * Подключиться к базе данных.
     */
    private function connect(): void
    {
        if ($this->pdo) {
            return;
        }

        $this->pdo = new \PDO(
            \sprintf('mysql:host=%s;dbname=%s', $this->config->getHost(), $this->config->getDatabase()),
            (string) $this->config->getUser(),
            (string) $this->config->getPassword()
        );

        $this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(\PDO::ERRMODE_EXCEPTION, true);
    }

    /**
     * Создать PDO запрос и выполнить его.
     *
     * @param string $query
     * @param array  $args
     *
     * @return \PDOStatement
     */
    private function executeQuery(string $query, array $args): \PDOStatement
    {
        $statement = $this->pdo->prepare($query);
        if (!$statement) {
            echo print_r($this->pdo->errorInfo(), true);
        }

        foreach ($args as $key => $value) {
            $value = $this->processValue($value);
            $statement->bindValue($key, $value, \is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        $statement->execute();

        return $statement;
    }
}
