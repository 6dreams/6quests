<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model\DTO;

use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;
use SixQuests\Domain\Specification\DateTimeSpecification;

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
    private $data;

    /**
     * @var Point
     */
    private $point;

    /**
     * TeamInfo constructor.
     *
     * @param Team      $team
     * @param TeamPoint $info
     * @param Point     $point
     */
    public function __construct(Team $team, TeamPoint $info, Point $point)
    {
        $this->team  = $team;
        $this->data  = $info;
        $this->point = $point;
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
     * Получение данных о команде на точке.
     *
     * @return TeamPoint
     */
    public function getData(): TeamPoint
    {
        return $this->data;
    }

    /**
     * Точка пройдена.
     *
     * @return bool
     */
    public function getIsFinished(): bool
    {
        if ($this->data->getDeparted() !== null) {
            return true;
        }

        if ($this->data->getArrived() !== null) {
            return (new DateTimeSpecification(
                (clone $this->data->getArrived())->modify(\sprintf('+%dminutes', $this->point->getTimeLimit())),
                new \DateTime()
            ))->less();
        }

        return false;
    }

    /**
     * JSON для front-end.
     *
     * @return array
     */
    public function getJSON(): array
    {
        return [
            'id' => $this->team->getId(),
            'arrived' => $this->data->getArrived() ? $this->data->getArrived()->getTimestamp() : null,
            'departed' => $this->data->getDeparted() ? $this->data->getDeparted()->format('d.m.Y H:i') : null,
            'finished' => $this->getIsFinished(),
            'hints' => $this->data->getHintsUsed()
        ];
    }
}
