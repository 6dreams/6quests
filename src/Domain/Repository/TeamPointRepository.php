<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class TeamPointRepository
 *
 * @method TeamPoint getById(int $id);
 * @method bool upsert(TeamPoint $model);
 *
 * @package SixQuests\Domain\Repository
 */
class TeamPointRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return TeamPoint::class;
    }

    /**
     * Получить информацию по командам на точке.
     *
     * @param Point $point
     * @return array
     */
    public function getTeamPointsByPoint(Point $point): array
    {
        return $this
            ->getResults(
                'SELECT ~fields FROM ~table WHERE `point_id`=:point_id',
                [ 'point_id' => $point->getId() ]
            );
    }
}
