<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DTO\Query;
use SixQuests\Domain\Model\Team;

/**
 * Class DatabaseTeamTransformer
 */
class DatabaseTeamTransformer extends AbstractDatabaseTransformer
{
    /**
     * Трансформировать массив из базы в объект команды.
     *
     * @param array $data
     *
     * @return Team
     */
    public function transform(array $data): Team
    {
        return (new Team())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setColor($data['color'] ?? '')
            ->setNumber($data['number'] ?? 0)
            ->setFinished($data['finished'] ? new \DateTime($data['finished']) : null)
            ->setQuestId($data['quest_id'] ?? 0);
    }

    /**
     * {@inheritdoc}
     * @param Team $team
     */
    public function detransform($team): Query
    {
        return $this
            ->addField('name', $team->getName())
            ->addField('color', $team->getColor())
            ->addField('number', $team->getNumber())
            ->addField('quest_id', $team->getQuestId())
            ->addField('finished', $team->getFinished())
            ->build(Team::TABLE, $team->getId());
    }


    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Team::class;
    }
}
