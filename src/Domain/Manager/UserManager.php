<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Repository\UserRepository;

/**
 * Class UserManager
 * @package SixQuests\Domain\Manager
 */
class UserManager
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}
