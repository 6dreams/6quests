<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Repository\TeamPointRepository;

/**
 * Class TeamPointManager
 * @package SixQuests\Domain\Manager
 */
class TeamPointManager
{
    /**
     * @var TeamPointRepository
     */
    private $teamPoints;

    /**
     * TeamPointManager constructor.
     *
     * @param TeamPointRepository $repository
     */
    public function __construct(TeamPointRepository $repository)
    {
        $this->teamPoints = $repository;
    }

    /**
     * @param Point $point
     * @return array
     */
    public function getTeamsByPoints(Point $point): array
    {
        return $this->teamPoints->getTeamPointsByPoint($point);
    }
}
