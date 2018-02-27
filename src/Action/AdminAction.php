<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\RedirectException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\PointManager;
use SixQuests\Domain\Manager\QuestManager;
use SixQuests\Domain\Manager\TeamManager;
use SixQuests\Domain\Manager\TeamPointManager;
use SixQuests\Domain\Model\Quest;
use SixQuests\Responder\Admin\AdminQuestListResponder;
use SixQuests\Responder\Admin\AdminQuestViewResponder;
use SixQuests\Responder\RedirectResponder;
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

    public function questView(Request $request, AdminQuestViewResponder $responder): Response
    {
        try {
            $this->authManager->checkAdminAuth();
        } catch (RedirectException $e) {
            return ($this->redirector)($e->getUser());
        }

        return $responder($this->questManager->getQuest((int) $request->get('id')));
    }

    public function questStart(Request $request)
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

        return new Response('eda');
    }
}
