<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\PointManager;
use SixQuests\Domain\Manager\TeamManager;
use SixQuests\Domain\Manager\TeamPointManager;
use SixQuests\Responder\Point\PointListResponder;
use SixQuests\Responder\Point\PointViewResponder;
use SixQuests\Responder\RedirectResponder;
use SixQuests\Responder\RouteRedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PointAction
 * @package SixQuests\Action
 */
class PointAction
{
    /**
     * @var PointManager
     */
    private $pointManager;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @var RedirectResponder
     */
    private $redirector;

    /**
     * @var TeamPointManager
     */
    private $teamPointManager;

    /**
     * @var TeamManager
     */
    private $teamManager;

    /**
     * PointAction constructor.
     *
     * @param PointManager      $manager
     * @param TeamManager       $teamManager
     * @param TeamPointManager  $teamPointManager
     * @param AuthManager       $authManager
     * @param RedirectResponder $responder
     */
    public function __construct(
        PointManager $manager,
        TeamManager $teamManager,
        TeamPointManager $teamPointManager,
        AuthManager $authManager,
        RedirectResponder $responder
    ) {
        $this->pointManager = $manager;
        $this->authManager = $authManager;
        $this->redirector = $responder;
        $this->teamManager = $teamManager;
        $this->teamPointManager = $teamPointManager;
    }

    /**
     * Список точек.
     *
     * @param RouteRedirectResponder $redirect
     * @param PointListResponder     $responder
     * @return Response
     */
    public function pointList(RouteRedirectResponder $redirect, PointListResponder $responder): Response
    {
        try {
            $user = $this->authManager->getThrowableUser();
        } catch (NoAuthException $e) {
            return ($this->redirector)();
        }

        $points = $this->pointManager->getActivePointsByUser($user);
        if (\count($points) === 1) {
            return $redirect('point_view', [ 'id' => $points[0]->getId() ]);
        }

        return $responder($points);
    }

    /**
     * Отобразить точку для координатора.
     *
     * @param Request            $request
     * @param PointViewResponder $responder
     * @return Response
     */
    public function pointView(Request $request, PointViewResponder $responder): Response
    {
        try {
            $user = $this->authManager->getThrowableUser();
        } catch (NoAuthException $e) {
            return ($this->redirector)();
        }

        $point = $this->pointManager->getActivePoint((int) $request->get('id'), $user);

        return $responder($point, $this->teamManager->getTeamInfoByTeamPoints($this->teamPointManager->getTeamsByPoints($point)));
    }
}