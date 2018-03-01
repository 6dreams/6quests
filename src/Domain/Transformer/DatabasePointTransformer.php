<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DTO\Query;
use SixQuests\Domain\Model\Point;

/**
 * Class DatabasePointTransformer
 */
class DatabasePointTransformer extends AbstractDatabaseTransformer
{
    /**
     * Преобразует массив из базы в объект точки квеста.
     *
     * @param array $data
     *
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
            ->setQuestId($data['quest_id'] ?? 0)
            ->setUserId($data['user_id'] ?? 0);
    }

    /**
     * {@inheritdoc}
     * @param Point $point
     */
    public function detransform($point): Query
    {
        return $this
            ->addField('name', $point->getName())
            ->addField('hints', $point->getHints())
            ->addField('hint_cost', $point->getHintCost())
            ->addField('skip_cost', $point->getSkipCost())
            ->addField('time_limit', $point->getTimeLimit())
            ->addField('quest_id', $point->getQuestId())
            ->addField('user_id', $point->getUserId())
            ->build(Point::TABLE, $point->getId());
    }


    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Point::class;
    }
}
