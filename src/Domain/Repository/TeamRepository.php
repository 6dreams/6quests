<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Team;

/**
 * Class TeamRepository
 *
 * @method Team getById(int $id);
 * @method bool upsert(Team $model);
 *
 * @package SixQuests\Domain\Repository
 */
class TeamRepository extends AbstractRepository
{
    protected static $table = Team::TABLE;

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Team::class;
    }
}
