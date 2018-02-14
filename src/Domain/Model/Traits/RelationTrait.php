<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model\Traits;

use SixQuests\Database\Driver;
use SixQuests\Domain\Model\ModelInterface;

/**
 * Class RelationTrait
 * @package SixQuests\Domain\Model\Traits
 */
trait RelationTrait
{
    /**
     * @var Driver
     */
    private $driver;

    private $relations = [];

    /**
     * @param Driver $driver
     * @return self
     */
    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Получить связь.
     *
     * @param string $name
     * @return array|mixed
     */
    protected function getRelation(string $name)
    {
        $rel = $this->relations[$name];

        $args = [];
        $argId = 1;
        foreach ($rel['args'] as $arg) {
            $args['arg' . $argId] = $this->{'get' . \ucfirst($arg)}();
        }

        $ret = $this
            ->driver
            ->executeFind($rel['model'], \str_replace('&', $this->driver->getPrefix(), $rel['query']), $args);

        if ($rel['type'] === ModelInterface::RELATION_ONE2ONE) {
            return \array_shift($ret);
        }

        return $ret;
    }

    /**
     * Создать связь.
     *
     * @param int    $type тип
     * @param string $fcqn модель
     * @param string $name
     * @param string $query
     * @param array  $args
     */
    protected function createRelation(int $type, string $fcqn, string $name, string $query, array $args = [])
    {
        if (!\count($args)) {
            $args[] = $name;
        }

        $this->relations['user_id'] = [
            'type'  => $type,
            'query' => $query,
            'model' => $fcqn,
            'args'  => $args
        ];
    }
}