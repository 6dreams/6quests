<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Exception\NoAuthException;
use SixQuests\Domain\Exception\RedirectException;
use SixQuests\Domain\Model\User;
use SixQuests\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class AuthManager
 */
class AuthManager
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * AuthManager constructor.
     *
     * @param SessionInterface $session
     * @param UserRepository   $users
     */
    public function __construct(SessionInterface $session, UserRepository $users)
    {
        $this->session = $session;
        $this->users   = $users;
    }

    /**
     * Получить залогиненного в системе пользователя.
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->users->getById((int) $this->session->get('user_id'));
    }

    /**
     * Получить залогиненного в системе пользователя или бросить исключение.
     *
     * @return User
     *
     * @throws NoAuthException
     */
    public function getThrowableUser(): User
    {
        $user = $this->getUser();

        if (!$user) {
            throw new NoAuthException();
        }

        return $user;
    }

    /**
     * Проверка, есть ли залогиненый пользователь.
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->getUser() !== null;
    }

    /**
     * Авторизовать пользователя с указанными данными.
     *
     * @param string $login
     * @param string $password
     *
     * @return User
     *
     * @throws NoAuthException
     */
    public function authUser(string $login, string $password): User
    {
        $user = $this->users->getUserByLoginPassword($login, $password);

        if (!$user) {
            throw new NoAuthException();
        }

        $this->session->set('user_id', $user->getId());

        return $user;
    }

    /**
     * Проверить является ли пользователь админом.
     *
     * @throws RedirectException
     */
    public function checkAdminAuth(): void
    {
        $user = $this->getUser();
        if (!$user || !$user->isAdmin()) {
            throw new RedirectException($user);
        }
    }

    /**
     * Выйти из аккаунта.
     */
    public function logout(): void
    {
        $this->session->clear();
    }
}
