<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Manager\AuthManager;
use SixQuests\Responder\LoginResponder;
use SixQuests\Responder\RedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginAction
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
     * @var LoginResponder
     */
    private $responder;

    /**
     * LoginAction constructor.
     *
     * @param AuthManager       $authManager
     * @param RedirectResponder $redirectResponder
     * @param LoginResponder    $responder
     */
    public function __construct(AuthManager $authManager, RedirectResponder $redirectResponder, LoginResponder $responder)
    {
        $this->authManager = $authManager;
        $this->redirector  = $redirectResponder;
        $this->responder   = $responder;
    }

    /**
     * Отобразить форму авторизации.
     *
     * @return Response
     */
    public function form(): Response
    {
        if ($this->authManager->isAuth()) {
            return ($this->redirector)($this->authManager->getUser());
        }

        return ($this->responder)();
    }

    /**
     * Авторизовать пользователя.
     *
     * @param Request $request
     *
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
            return ($this->responder)(true);
        }

        return ($this->redirector)($user);
    }

    /**
     * Выйти.
     *
     * @return Response
     */
    public function logout(): Response
    {
        $this->authManager->logout();

        return ($this->responder)(false);
    }
}
