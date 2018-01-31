<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DTO\Query;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class DatabaseTeamPointTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseTeamPointTransformer extends AbstractDatabaseTransformer
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
     * @param TeamPoint $teamPoint
     */
    public function detransform($teamPoint): Query
    {
        return $this
            ->addField('arrived', $teamPoint->getArrived())
            ->addField('departed', $teamPoint->getDeparted())
            ->addField('hints_used', $teamPoint->getHintsUsed())
            ->addField('point_id', $teamPoint->getPoint())
            ->addField('team_id', $teamPoint->getTeam())
            ->build(TeamPoint::TABLE, $teamPoint->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return TeamPoint::class;
    }
}
