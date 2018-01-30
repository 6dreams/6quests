<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Domain\Model\Point;

/**
 * Class DatabasePointTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabasePointTransformer implements DatabaseTransformerInterface
{
    /**
     * Преобразует массив из базы в объект точки квеста.
     *
     * @param array $data
     * @return Point
     */
    public function transform(array $data): Point
    {
        return (new Point())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setHints($data['hints'] ?? 0)
            ->setHintCost($data['hint_cost'] ?? 0)
            ->setSkipCost($data['skip_cost'] ?? 0)
            ->setTimeLimit($data['time_limit'] ?? 0)
            ->setQuest($data['id'] ?? 0)
            ->setUser($data['user_id'] ?? 0);
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Point::class;
    }
}
