<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Model\DTO\TeamInfo;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;
use SixQuests\Domain\Repository\TeamRepository;

/**
 * Class TeamManager
 * @package SixQuests\Domain\Manager
 */
class TeamManager
{
    /**
     * @var TeamRepository
     */
    private $teams;

    /**
     * TeamManager constructor.
     *
     * @param TeamRepository $teams
     */
    public function __construct(TeamRepository $teams)
    {
        $this->teams = $teams;
    }

    /**
     * Получить команду по ID.
     *
     * @param int $id
     * @return Team
     */
    public function getTeam(int $id): Team
    {
        return $this->teams->getById($id);
    }

    /**
     * @param TeamPoint[] $teamPoints
     * @return TeamInfo[]
     */
    public function getTeamInfoByTeamPoints(array $teamPoints): array
    {
        return \array_map(function (TeamPoint $point) {
            return new TeamInfo($this->getTeam($point->getTeam()), $point);
        }, $teamPoints);
    }
}
