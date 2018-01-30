<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class DatabaseTeamPointTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseTeamPointTransformer implements DatabaseTransformerInterface
{
    /**
     * Преобразует массив из базы в объект команды на точке.
     *
     * @param array $data
     * @return TeamPoint
     */
    public function transform(array $data): TeamPoint
    {
        return (new TeamPoint())
            ->setId($data['id'] ?? 0)
            ->setArrived($data['arrived'] ?? null)
            ->setDeparted($data['departed'] ?? null)
            ->setHintsUsed($data['hints_used'] ?? 0)
            ->setPoint($data['point_id'] ?? 0)
            ->setTeam($data['team_id'] ?? 0);
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return TeamPoint::class;
    }
}
