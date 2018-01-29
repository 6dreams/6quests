<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Exeception\NoAuthException;
use SixQuests\Domain\Model\User;
use SixQuests\Domain\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AuthManager
 * @package SixQuests\Domain\Manager
 */
class AuthManager
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * AuthManager constructor.
     *
     * @param Session        $session
     * @param UserRepository $users
     */
    public function __construct(Session $session, UserRepository $users)
    {
        $this->session = $session;
        $this->users   = $users;
    }

    public function getUser(): User
    {
        $userId = $this->session->get('user_id');

        if (!$userId) {
            throw new NoAuthException();
        }

        return new User();
    }

    /**
     * Проверка, есть ли залогиненый пользователь.
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        try {
            return $this->getUser() !== null;
        } catch (NoAuthException) {
            return false;
        }
    }
}
