<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixQuests\Database\Exception\NotSupportedModelException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Driver
 * @package SixQuests\Database
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
     * Подключиться к базе данных.
     */
    private function connect(): void
    {
        if ($this->pdo) {
            return;
        }

        $this->pdo = new \PDO(
            \sprintf('mysql:host=%s;dbname=%s', $this->config->getHost(), $this->config->getDatabase()),
            $this->config->getUser(),
            $this->config->getPassword()
        );
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
     * @return array|mixed
     * @throws NotSupportedModelException
     */
    public function executeFind(string $model, string $query, array $args = [])
    {
        $this->connect();

        $statement = $this->pdo->prepare($query);

        foreach ($args as $key => $value) {
            $statement->bindValue($key, $value, \is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }

        $statement->execute();

        $results = [];
        foreach ($statement->fetchAll() as $result) {
            $results = $this->hydrator->hydrate($model, $result);
        }

        return $results;
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
}