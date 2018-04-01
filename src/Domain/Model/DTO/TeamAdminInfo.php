<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model\DTO;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;

/**
 * Class TeamAdminInfo
 *
 * @method Team getTeam();
 * @method int getPassing();
 * @method int getTotal();
 * @method int getPenalty();
 * @method TeamInfo[] getPoints();
 */
class TeamAdminInfo
{
    use RichModelTrait;

    /**
     * @var Team
     */
    protected $team;

    /**
     * @var int время прохождения
     */
    protected $passing = 0;

    /**
     * @var int общее время
     */
    protected $total = 0;

    /**
     * @var int штрафное время
     */
    protected $penalty = 0;

    /**
     * @var TeamPointAdminInfo[]
     */
    protected $points = [];

    /**
     * @var int
     */
    protected $totalHints = 0;

    /**
     * @var int
     */
    protected $totalHintsUsed = 0;

    /**
     * TeamAdminInfo constructor.
     *
     * @param Team        $team
     * @param TeamPoint[] $points
     */
    public function __construct(Team $team, array $points)
    {
        $this->team = $team;
        $quest = $team->getQuest();
        if (!$quest) {
            return;
        }
        foreach ($points as $tp) {
            $point = $tp->getPoint();
            if (!$point) {
                continue;
            }

            $this->points[] = new TeamPointAdminInfo($tp, $point);

            $this->totalHints += $point->getHints();
            $this->totalHintsUsed += $tp->getHintsUsed();

            // пропуск точки, если команда уже на финише.
            if ($tp->getArrived() === null && $team->isFinished()) {
                $this->penalty += $point->getSkipCost() * 60;
                continue;
            }

            // использование подсказок.
            $this->penalty += $tp->getHintsUsed() * $point->getHintCost() * 60;
        }

        // (времяКогдаПрибылиНаФиниш | текущееВремя) - времяНачалаКвеста
        $this->passing = ($team->getFinished() ?? new \DateTime())->getTimestamp() - $quest->getDate()->getTimestamp();
        // времяПрохождения + штрафы
        $this->total = $this->penalty + $this->passing;
    }

    /**
     * Форматировать секунды в hour:minite формат.
     *
     * @param int $value
     *
     * @return string
     */
    public function getFormatted(int $value): string
    {
        $hours = \floor($value / 3600);
        $minutes = \floor(($value / 60) % 60);

        return \sprintf('%02d:%02d', $hours, $minutes);
    }
}
