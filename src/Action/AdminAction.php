<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Domain\Manager\QuestManager;
use SixQuests\Responder\AdminQuestListResponder;
use SixQuests\Responder\RedirectResponder;
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
            $user = $this->authManager->getThrowableUser();
            if (!$user->isAdmin()) {
                return ($this->redirector)($user);
            }
        } catch (NoAuthException $e) {
            return ($this->redirector)();
        }

        return ($this->responder)($this->questManager->getAdminQuests());
    }
}
