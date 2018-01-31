<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixQuests\Database\DTO\Query;

/**
 * Interface DatabaseTransformerInterface
 * @package SixQuests\Database
 */
interface DatabaseTransformerInterface
{
    /**
     * Трансформирует ответ из базы данных в объект.
     *
     * @param array $data
     * @return mixed
     */
    public function transform(array $data);

    /**
     * Трансформировать объект в запрос изменения или обновления.
     *
     * @param mixed $object
     * @return Query
     */
    public function detransform($object): Query;

    /**
     * Какую модель может трансформировать этот трансформер.
     *
     * @return string
     */
    public function getModel(): string;
}
