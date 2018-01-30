<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Exception;

use SixQuests\Domain\Model\User;

/**
 * Class RedirectException
 * @package SixQuests\Domain\Exception
 */
class RedirectException extends \Exception
{
    /**
     * @var null|User
     */
    private $user;

    /**
     * RedirectException constructor.
     *
     * @param null|User $user
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Получение User
     *
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}