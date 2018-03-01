<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class TeamPointRepository
 *
 * @method TeamPoint getById(int $id);
 * @method bool upsert(TeamPoint $model);
 */
class TeamPointRepository extends AbstractRepository
{
    /**
     * Получить информацию по командам на точке.
     *
     * @param Point $point
     *
     * @return TeamPoint[]
     */
    public function getTeamPointsByPoint(Point $point): array
    {
        return $this
            ->getResults(
                'SELECT ~fields FROM ~table WHERE `point_id`=:point_id',
                [ 'point_id' => $point->getId() ]
            );
    }

    /**
     * Получить информацию по командам на точке по команде.
     *
     * @param Team $team
     *
     * @return TeamPoint[]
     */
    public function getTeamPointsByTeam(Team $team): array
    {
        return $this
            ->getResults(
                'SElECT ~fields FROM ~table WHERE `team_id`=:team_id',
                [ 'team_id' => $team->getId() ]
            );
    }

    /**
     * Найти точку команды по точке и команде.
     *
     * @param Team  $team
     * @param Point $point
     *
     * @return TeamPoint|null
     */
    public function getTeamPointByTeamAndPoint(Team $team, Point $point): ?TeamPoint
    {
        return $this
            ->getResult(
                'SELECT ~fields FROM ~table WHERE `point_id`=:point_id AND `team_id`=:team_id',
                [
                    'team_id' => $team->getId(),
                    'point_id' => $point->getId()
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return TeamPoint::class;
    }
}
