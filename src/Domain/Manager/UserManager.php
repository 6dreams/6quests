<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Repository\UserRepository;

/**
 * Class UserManager
 */
class UserManager
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получить пользовательский репозиторий.
     *
     * @return UserRepository
     */
    public function getRepository(): UserRepository
    {
        return $this->repository;
    }
}
