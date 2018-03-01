<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Exception\LogicException;
use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\TeamPoint;
use SixQuests\Domain\Repository\TeamPointRepository;
use SixQuests\Domain\Specification\DateTimeSpecification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TeamPointManager
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
     *
     * @return array
     */
    public function getTeamsByPoints(Point $point): array
    {
        return $this->teamPoints->getTeamPointsByPoint($point);
    }

    /**
     * Создать точку для команды.
     *
     * @param Team  $team
     * @param Point $point
     */
    public function create(Team $team, Point $point): void
    {
        $this->teamPoints->upsert(
            (new TeamPoint())
                ->setHintsUsed(0)
                ->setPointId($point->getId())
                ->setTeamId($team->getId())
        );
    }

    /**
     * Найти точку команды по точке и команде.
     *
     * @param Team  $team
     * @param Point $point
     *
     * @return TeamPoint
     */
    public function getTeamPointByTeamAndPoint(Team $team, Point $point): TeamPoint
    {
        $tp = $this->teamPoints->getTeamPointByTeamAndPoint($team, $point);
        if (!$tp) {
            throw new NotFoundHttpException();
        }

        return $tp;
    }

    /**
     * Сохранить состояния прибытия команды на точку.
     *
     * @param TeamPoint $teamPoint
     *
     * @return TeamPoint
     *
     * @throws LogicException
     */
    public function teamArrivePoint(TeamPoint $teamPoint): TeamPoint
    {
        if ($teamPoint->getArrived() !== null) {
            throw new LogicException();
        }

        $teamPoint->setArrived(new \DateTime());
        $this->teamPoints->upsert($teamPoint);

        return $teamPoint;
    }

    /**
     * Сохранить состояние отбытия команды с точки.
     *
     * @param TeamPoint $teamPoint
     * @param Point     $point
     *
     * @return TeamPoint
     *
     * @throws LogicException
     */
    public function teamDepartPoint(TeamPoint $teamPoint, Point $point): TeamPoint
    {
        $this->canModifyTeamOnPoint($teamPoint, $point);

        $this->teamPoints->upsert($teamPoint->setDeparted(new \DateTime()));

        return $teamPoint;
    }

    /**
     * Команда использует подсказку на точке.
     *
     * @param TeamPoint $teamPoint
     * @param Point     $point
     *
     * @return TeamPoint
     *
     * @throws LogicException
     */
    public function teamAskHint(TeamPoint $teamPoint, Point $point): TeamPoint
    {
        $this->canModifyTeamOnPoint($teamPoint, $point);

        if ((int) $point->getHints() <= (int) $teamPoint->getHintsUsed()) {
            throw new LogicException();
        }

        $this->teamPoints->upsert($teamPoint->setHintsUsed(((int) $teamPoint->getHintsUsed()) + 1));

        return $teamPoint;
    }

    /**
     * @param TeamPoint $teamPoint
     * @param Point     $point
     *
     * @return bool
     *
     * @throws LogicException
     */
    private function canModifyTeamOnPoint(TeamPoint $teamPoint, Point $point): bool
    {
        if ($teamPoint->getArrived() === null || $teamPoint->getDeparted() !== null) {
            throw new LogicException();
        }

        if ((new DateTimeSpecification((clone $teamPoint->getArrived())->modify(sprintf('+%dminutes', $point->getTimeLimit())), new \DateTime()))->less()) {
            throw new LogicException();
        }

        return true;
    }
}
