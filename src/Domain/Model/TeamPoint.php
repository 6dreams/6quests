<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Traits\RelationTrait;

/**
 * Class TeamPoint
 *
 * @method int getId();
 * @method TeamPoint setId(int $id);
 *
 * @method \DateTime getArrived();
 * @method TeamPoint setArrived(\DateTime $id);
 *
 * @method \DateTime getDeparted();
 * @method TeamPoint setDeparted(\DateTime $id);
 *
 * @method int getHintsUsed();
 * @method TeamPoint setHintsUsed(int $amount);
 *
 * @method int getTeamId();
 * @method TeamPoint setTeamId(int $id);
 *
 * @method int getPointId();
 * @method TeamPoint setPointId(int $id);
 */
class TeamPoint
{
    use RichModelTrait, RelationTrait;

    public const TABLE = 'team_points';

    public const FIELDS = ['id', 'arrived', 'departed', 'hints_used', 'team_id', 'point_id'];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $arrived;

    /**
     * @var \DateTime
     */
    protected $departed;

    /**
     * @var int
     */
    protected $hintsUsed;

    /**
     * @var int
     */
    protected $teamId;

    /**
     * @var int
     */
    protected $pointId;

    /**
     * TeamPoint constructor.
     */
    public function __construct()
    {
        $this
            ->createRelation(ModelInterface::RELATION_ONE2ONE, Team::class, 'teamId', 'SELECT * FROM &' . Team::TABLE . ' WHERE id = :arg1')
            ->createRelation(ModelInterface::RELATION_ONE2ONE, Point::class, 'pointId', 'SELECT * FROM &' . Point::TABLE . ' WHERE id = :arg1');
    }

    /**
     * Получить команду.
     *
     * @return null|Team
     */
    public function getTeam(): ?Team
    {
        return $this->getRelation('teamId');
    }

    /**
     * Получить точку.
     *
     * @return null|Point
     */
    public function getPoint(): ?Point
    {
        return $this->getRelation('pointId');
    }
}
