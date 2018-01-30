<?php
declare(strict_types=1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Domain\Model\Team;

/**
 * Class DatabaseTeamTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseTeamTransformer implements DatabaseTransformerInterface
{
    /**
     * Трансформировать массив из базы в объект команды.
     *
     * @param array $data
     * @return Team
     */
    public function transform(array $data): Team
    {
        return (new Team())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setColor($data['color'] ?? '')
            ->setNumber($data['number'] ?? 0)
            ->setQuest($data['quest_id'] ?? 0);
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Team::class;
    }
}
