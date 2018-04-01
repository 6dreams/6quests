<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model\DTO;
use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class TeamPointAdminInfo
 *
 * @method Point getPoint();
 * @method TeamPoint getTeamPoint();
 * @method Team getTeam();
 */
class TeamPointAdminInfo
{
    use RichModelTrait;

    /**
     * @var TeamPoint
     */
    private $teamPoint;

    /**
     * @var Point
     */
    private $point;

    /**
     * @var Team
     */
    private $team;

    /**
     * TeamPointAdminInfo constructor.
     *
     * @param TeamPoint  $teamPoint
     * @param Point|null $point
     */
    public function __construct(TeamPoint $teamPoint, ?Point $point = null)
    {
        $this->teamPoint = $teamPoint;
        $this->point     = $point ?? $teamPoint->getPoint();
        $this->team      = $teamPoint->getTeam();
    }

    /**
     * Команда пропустила точку?
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->teamPoint->getArrived() === null;
    }

    /**
     * Штрафы за точку.
     *
     * @return int
     */
    public function getPenalty(): int
    {
        $hints = $this->teamPoint->getHintsUsed() * $this->point->getHintCost() * 60;
        $skip  = $this->point->getSkipCost() * 60;

        if ($this->team->isFinished()) {
            if ($this->isSkipped()) {
                return $skip;
            }
        }

        return $hints;
    }
}
