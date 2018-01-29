<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Responder\RedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginAction
 * @package SixQuests\Action
 */
class LoginAction
{
    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @var RedirectResponder
     */
    private $redirector;

    /**
     * LoginAction constructor.
     *
     * @param AuthManager       $authManager
     * @param RedirectResponder $redirectResponder
     */
    public function __construct(AuthManager $authManager, RedirectResponder $redirectResponder)
    {
        $this->authManager = $authManager;
        $this->redirector  = $redirectResponder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function form(Request $request): Response
    {
        if ($this->authManager->isAuth()) {
            return ($this->redirector)($this->authManager->getUser());
        }

        return new Response($request->getUri());
    }

    /**
     * Авторизовать пользователя.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        try {
            $user = $this->authManager->authUser(
                (string) $request->get('login'),
                (string) $request->get('password')
            );
        } catch (NoAuthException $e) {
            $user = null;
        }

        return ($this->redirector)($user);
    }
}