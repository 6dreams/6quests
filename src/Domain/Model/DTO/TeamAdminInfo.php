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
     * TeamAdminInfo constructor.
     *
     * @param Team        $team
     * @param TeamPoint[] $points
     */
    public function __construct(Team $team, array $points)
    {
        $this->team = $team;
        foreach ($points as $tp) {
            $point = $tp->getPoint();
            if (!$point) {
                continue;
            }

            // пропуск точки, если команда уже на финише.
            if ($tp->getArrived() === null && $team->isFinished()) {
                $this->penalty += $point->getSkipCost() * 60;
                continue;
            }


            if ($tp->getDeparted() === null) {
                // загадка не отгадана, а команда уже на финише
                if ($team->isFinished()) {
                    $this->passing += $point->getTimeLimit() * 60;
                }
            } else {
                // загадку отгадали
                $this->passing += $tp->getDeparted()->getTimestamp() - $tp->getArrived()->getTimestamp();
            }

            // использование подсказок (отображаем всегда).
            $this->penalty += $tp->getHintsUsed() * $point->getHintCost() * 60;
        }

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
        return \gmdate('H:i', $value);
    }
}
