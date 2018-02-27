<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Quest;
use SixQuests\Domain\Model\User;

/**
 * Class PointRepository
 *
 * @method Point getById(int $id);
 * @method bool upsert(Point $model);
 */
class PointRepository extends AbstractRepository
{
    /**
     * Получить все точки доступные пользователю.
     *
     * @param User $user
     *
     * @return array
     */
    public function getActivePointsByUser(User $user): array
    {
        return $this->getResults(
            'SELECT ~fields FROM ~table LEFT JOIN `&quests` ON ~table.`quest_id` = `&quests`.`id` WHERE `user_id` = :user_id AND `&quests`.`state` = :active_quest',
            [
                'user_id' => $user->getId(),
                'active_quest' => Quest::STATE_ACTIVE
            ]
        );
    }

    /**
     * Получить активную точку, привязанную к пользователю, если она есть.
     *
     * @param User $user
     * @param int  $id
     *
     * @return null|Point
     */
    public function getActivePoint(User $user, int $id): ?Point
    {
        return $this->getResult(
            'SELECT ~fields FROM ~table LEFT JOIN `&quests` ON ~table.`quest_id` = `&quests`.`id` WHERE `user_id` = :user_id AND `&quests`.`state` = :active_quest AND ~table.`id`=:point_id',
            [
                'user_id' => $user->getId(),
                'active_quest' => Quest::STATE_ACTIVE,
                'point_id' => $id
            ]
        );
    }

    /**
     * Получить точки по квесту.
     *
     * @param Quest $quest
     *
     * @return array
     */
    public function getPointsByQuest(Quest $quest): array
    {
        return $this->getResults(
            'SELECT ~fields FROM ~table LEFT JOIN `&quests` ON ~table.`quest_id` = `&quests`.`id` WHERE `&quests`.`id` = :quest_id',
            [
                'quest_id' => $quest->getId()
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Point::class;
    }
}
