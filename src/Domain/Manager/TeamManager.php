<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Model\DTO\TeamInfo;
use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;
use SixQuests\Domain\Repository\TeamRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $team = $this->teams->getById($id);
        if (!$team) {
            throw new NotFoundHttpException();
        }

        return $team;
    }

    /**
     * Создать DTO содержащую информацию по команде.
     *
     * @param Team      $team
     * @param Point     $point
     * @param TeamPoint $teamPoint
     * @return TeamInfo
     */
    public function getTeamInfo(Team $team, Point $point, TeamPoint $teamPoint): TeamInfo
    {
        return new TeamInfo($team, $teamPoint, $point);
    }

    /**
     * Получить информацию о команде на точке.
     *
     * @param TeamPoint[] $teamPoints
     * @param Point       $point
     * @return TeamInfo[]
     */
    public function getTeamInfoByTeamPoints(array $teamPoints, Point $point): array
    {
        return \array_map(function (TeamPoint $tp) use ($point) {
            return $this->getTeamInfo($this->getTeam($tp->getTeamId()), $point, $tp);
        }, $teamPoints);
    }
}
