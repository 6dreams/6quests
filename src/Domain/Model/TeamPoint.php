<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

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
 * @method int getTeam();
 * @method TeamPoint setTeam(int $id);
 *
 * @method int getPoint();
 * @method TeamPoint setPoint(int $id);
 *
 * @package SixQuests\Domain\Model
 */
class TeamPoint
{
    use RichModelTrait;

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
    protected $hintUsed;

    /**
     * @var int
     */
    protected $team;

    /**
     * @var int
     */
    protected $point;
}