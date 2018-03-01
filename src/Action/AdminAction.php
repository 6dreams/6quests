<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\RedirectException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\PointManager;
use SixQuests\Domain\Manager\QuestManager;
use SixQuests\Domain\Manager\TeamManager;
use SixQuests\Domain\Manager\TeamPointManager;
use SixQuests\Domain\Model\DTO\TeamAdminInfo;
use SixQuests\Domain\Model\Quest;
use SixQuests\Responder\Admin\AdminQuestHandleResponder;
use SixQuests\Responder\Admin\AdminQuestListResponder;
use SixQuests\Responder\Admin\AdminQuestViewResponder;
use SixQuests\Responder\RedirectResponder;
use SixQuests\Responder\RouteRedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminAction
 */
class AdminAction
{
    /**
     * @var AdminQuestListResponder
     */
    private $responder;

    /**
     * @var RedirectResponder
     */
    private $redirector;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @var QuestManager
     */
    private $questManager;

    /**
     * @var TeamManager
     */
    private $teamManager;

    /**
     * @var PointManager
     */
    private $pointManager;

    /**
     * @var TeamPointManager
     */
    private $teamPointManager;

    /**
     * AdminAction constructor.
     *
     * @param AuthManager             $authManager
     * @param AdminQuestListResponder $responder
     * @param RedirectResponder       $redirector
     * @param QuestManager            $questManager
     * @param PointManager            $pointManager
     * @param TeamManager             $teamManager
     * @param TeamPointManager        $teamPointManager
     */
    public function __construct(
        AuthManager $authManager,
        AdminQuestListResponder $responder,
        RedirectResponder $redirector,
        QuestManager $questManager,
        PointManager $pointManager,
        TeamManager $teamManager,
        TeamPointManager $teamPointManager
    ) {
        $this->responder = $responder;
        $this->authManager = $authManager;
        $this->redirector = $redirector;
        $this->questManager = $questManager;
        $this->pointManager = $pointManager;
        $this->teamManager = $teamManager;
        $this->teamPointManager = $teamPointManager;
    }

    /**
     * Получить список всех (кроме старых) квестов.
     *
     * @return Response
     */
    public function questSelect(): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        return ($this->responder)($this->questManager->getAdminQuests());
    }

    /**
     * Базовый просмотр квеста.
     *
     * @param Request                 $request
     * @param AdminQuestViewResponder $responder
     * @param RouteRedirectResponder  $redirect
     *
     * @return Response
     */
    public function questView(Request $request, AdminQuestViewResponder $responder, RouteRedirectResponder $redirect): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        $quest = $this->questManager->getQuest((int) $request->get('id'));

        if ($quest->getState() === Quest::STATE_UNKNOWN) {
            return $responder($quest);
        }

        return $redirect('quest_handler', [ 'id' => $quest->getId() ]);
    }

    /**
     * Начать квест!
     *
     * @param Request                $request
     * @param RouteRedirectResponder $redirect
     *
     * @return Response
     */
    public function questStart(Request $request, RouteRedirectResponder $redirect): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        $quest = $this->questManager->getQuest((int) $request->get('id'));
        if ($quest->getState() === Quest::STATE_UNKNOWN) {
            $this->questManager->startQuest($quest);
            $points = $this->pointManager->getRepository()->getPointsByQuest($quest);
            $teams = $this->teamManager->getRepository()->getTeamsByQuest($quest);
            foreach ($points as $point) {
                foreach ($teams as $team) {
                    $this->teamPointManager->create($team, $point);
                }
            }
        }

        return $redirect('quest_handler', [ 'id' => $quest->getId() ]);
    }

    /**
     * Завершение квеста для команды.
     *
     * @param Request                $request
     * @param RouteRedirectResponder $redirect
     *
     * @return Response
     */
    public function questFinish(Request $request, RouteRedirectResponder $redirect): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        $team = $this->teamManager->getTeam((int) $request->get('id'));
        $this->teamManager->finish($team);

        $quest = $team->getQuest();
        if (!$quest) {
            return ($this->redirector)($this->authManager->getUser());
        }

        $teams = $this->teamManager->getRepository()->getTeamsByQuest($quest);
        foreach ($teams as $team) {
            if (!$team->isFinished()) {
                return $redirect('quest_handler', [ 'id' => $quest->getId() ]);
            }
        }

        $this->questManager->finishQuest($quest);

        return $redirect('quest_handler', [ 'id' => $quest->getId() ]);
    }

    /**
     * Обработка квеста в админке.
     *
     * @param Request                   $request
     * @param AdminQuestHandleResponder $responder
     *
     * @return Response
     */
    public function questHandle(Request $request, AdminQuestHandleResponder $responder): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        $quest = $this->questManager->getQuest((int) $request->get('id'));

        $ret = [];
        $teams = $this->teamManager->getRepository()->getTeamsByQuest($quest);
        foreach ($teams as $team) {
            $ret[] = new TeamAdminInfo($team, $this->teamPointManager->getRepository()->getTeamPointsByTeam($team));
        }

        return $responder($quest, $ret);
    }
}
