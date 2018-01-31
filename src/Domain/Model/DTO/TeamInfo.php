<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model\DTO;

use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class TeamInfo
 * @package SixQuests\Domain\Model\DTO
 */
class TeamInfo
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @var TeamPoint
     */
    private $info;

    /**
     * TeamInfo constructor.
     *
     * @param Team      $team
     * @param TeamPoint $info
     */
    public function __construct(Team $team, TeamPoint $info)
    {
        $this->team = $team;
        $this->info = $info;
    }

    /**
     * Получение Team
     *
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * Получение Info
     *
     * @return TeamPoint
     */
    public function getInfo(): TeamPoint
    {
        return $this->info;
    }
}
