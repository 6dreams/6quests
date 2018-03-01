<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Quest;
use SixQuests\Domain\Model\Team;

/**
 * Class TeamRepository
 *
 * @method Team getById(int $id);
 * @method bool upsert(Team $model);
 */
class TeamRepository extends AbstractRepository
{
    /**
     * Получить все команды учавствующие в квесте.
     *
     * @param Quest $quest
     *
     * @return Team[]
     */
    public function getTeamsByQuest(Quest $quest): array
    {
        return $this->getResults(
            'SELECT ~fields FROM ~table WHERE `quest_id` = :quest_id',
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
        return Team::class;
    }
}
