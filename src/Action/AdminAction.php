<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\RedirectException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\QuestManager;
use SixQuests\Responder\Admin\AdminQuestListResponder;
use SixQuests\Responder\Admin\AdminQuestViewResponder;
use SixQuests\Responder\RedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminAction
 * @package SixQuests\Action
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

    public function __construct(
        AuthManager $authManager,
        AdminQuestListResponder $responder,
        RedirectResponder $redirector,
        QuestManager $questManager
    ) {
        $this->responder = $responder;
        $this->authManager = $authManager;
        $this->redirector = $redirector;
        $this->questManager = $questManager;
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

        return new Response('eda');
    }
}
