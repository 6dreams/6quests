<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\LogicException;
use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\PointManager;
use SixQuests\Domain\Manager\TeamManager;
use SixQuests\Domain\Manager\TeamPointManager;
use SixQuests\Responder\Team\TeamInfoResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TeamAction
 * @package SixQuests\Action
 */
class TeamAction
{
    /**
     * @var PointManager
     */
    private $pointManager;

    /**
     * @var TeamManager
     */
    private $teamManager;

    /**
     * @var TeamPointManager
     */
    private $teamPointManager;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * TeamAction constructor.
     *
     * @param PointManager     $manager
     * @param TeamManager      $teamManager
     * @param TeamPointManager $teamPointManager
     * @param AuthManager      $authManager
     */
    public function __construct(
        PointManager $manager,
        TeamManager $teamManager,
        TeamPointManager $teamPointManager,
        AuthManager $authManager
    ) {
        $this->teamPointManager = $teamPointManager;
        $this->teamManager = $teamManager;
        $this->authManager = $authManager;
        $this->pointManager = $manager;
    }

    /**
     * Обработать приход команды на точку.
     *
     * @param Request           $request
     * @param TeamInfoResponder $responder
     * @return Response
     */
    public function teamArrived(Request $request, TeamInfoResponder $responder): Response
    {
        try {
            $user = $this->authManager->getThrowableUser();
        } catch (NoAuthException $e) {
            throw new NotFoundHttpException();
        }

        $point     = $this->pointManager->getActivePoint((int) $request->get('point'), $user);
        $team      = $this->teamManager->getTeam((int) $request->get('team'));
        $teamPoint = $this->teamPointManager->getTeamPointByTeamAndPoint($team, $point);

        try {
            $teamPoint = $this->teamPointManager->teamArrivePoint($teamPoint);
        } catch (LogicException $e) {
            // stub.
        }

        return $responder($this->teamManager->getTeamInfo($team, $point, $teamPoint));
    }

    /**
     * Обработать отбытие команды с точки.
     *
     * @param Request           $request
     * @param TeamInfoResponder $responder
     * @return Response
     */
    public function teamDeparted(Request $request, TeamInfoResponder $responder): Response
    {
        try {
            $user = $this->authManager->getThrowableUser();
        } catch (NoAuthException $e) {
            throw new NotFoundHttpException();
        }

        $point     = $this->pointManager->getActivePoint((int) $request->get('point'), $user);
        $team      = $this->teamManager->getTeam((int) $request->get('team'));
        $teamPoint = $this->teamPointManager->getTeamPointByTeamAndPoint($team, $point);

        try {
            $teamPoint = $this->teamPointManager->teamDepartPoint($teamPoint, $point);
        } catch (LogicException $e) {
            // stub.
        }

        return $responder($this->teamManager->getTeamInfo($team, $point, $teamPoint));
    }

    /**
     * Обработать запрос подсказки.
     *
     * @param Request           $request
     * @param TeamInfoResponder $responder
     * @return Response
     */
    public function teamAskHint(Request $request, TeamInfoResponder $responder): Response
    {
        try {
            $user = $this->authManager->getThrowableUser();
        } catch (NoAuthException $e) {
            throw new NotFoundHttpException();
        }

        $point     = $this->pointManager->getActivePoint((int) $request->get('point'), $user);
        $team      = $this->teamManager->getTeam((int) $request->get('team'));
        $teamPoint = $this->teamPointManager->getTeamPointByTeamAndPoint($team, $point);

        try {
            $teamPoint = $this->teamPointManager->teamAskHint($teamPoint, $point);
        } catch (LogicException $e) {
            // stub.
        }

        return $responder($this->teamManager->getTeamInfo($team, $point, $teamPoint));
    }
}
