<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Point;

/**
 * Class PointRepository
 *
 * @method Point getById(int $id);
 * @method bool upsert(Point $model);
 *
 * @package SixQuests\Domain\Repository
 */
class PointRepository extends AbstractRepository
{
    protected static $table = Point::TABLE;

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Point::class;
    }
}
