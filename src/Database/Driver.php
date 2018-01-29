<?php
declare(strict_types = 1);

namespace SixQuests\Database;

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
     * SQL constructor.
     *
     * @param ContainerInterface $parameters
     */
    public function __construct(ContainerInterface $parameters)
    {
        $this->pdo = new \PDO(
            \sprintf('mysql:host=%s;dbname=%s', $parameters->getParameter('host'), $parameters->getParameter('database')),
            $parameters->getParameter('user'),
            $parameters->getParameter('password')
        );
    }

    /**
     * @param string $query
     */
    public function executeRawQuery(string $query): void
    {
        $this->pdo->exec($query);
    }
}