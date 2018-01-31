<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

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
    protected static $table = TeamPoint::TABLE;

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return TeamPoint::class;
    }
}
