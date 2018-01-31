<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Database\DTO\Query;

/**
 * Class AbstractDatabaseTransformer
 * @package SixQuests\Domain\Transformer
 */
abstract class AbstractDatabaseTransformer implements DatabaseTransformerInterface
{
    private $fields = [];

    /**
     * Добавить поле для запроса.
     *
     * @param string $name
     * @param $value
     * @return AbstractDatabaseTransformer
     */
    protected function addField(string $name, $value): self
    {
        $this->fields[$name] = $value;

        return $this;
    }

    /**
     * Создать upsert запрос к базе.
     *
     * @param string $table
     * @param int|null $id
     * @return Query
     */
    protected function build(string $table, ?int $id = null): Query
    {
        $query = '';
        $args = [];
        if ($id) {
            foreach ($this->fields as $name => $value) {
                $query .= \sprintf(
                    '%1$s `%2$s`=:value_%2$s',
                    $query === '' ? '' : ',',
                    $name
                );
                $args['value_' . $name] = $value;
            }
            $this->fields = [];

            return new Query('UPDATE `' . $table . '` ' . $query . ' WHERE `id`=:where_id', $args);
        }

        $args['where_id'] = $id;
        $names = $values = [];
        foreach ($this->fields as $name => $value) {
            $names[] = '`' . $name .'`';
            $values[] = ':value_' . $name;
            $args['value_' . $name] = $value;
        }

        return new Query(\sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            \implode(', ', $names),
            \implode(', ', $values)
        ), $args);
    }
}