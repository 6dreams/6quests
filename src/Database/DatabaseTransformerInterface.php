<?php
declare(strict_types = 1);

namespace SixQuests\Database;

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
     * Какую модель может трансформировать этот трансформер.
     *
     * @return string
     */
    public function getModel(): string;
}
