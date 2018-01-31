<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class User
 *
 * @method int getId();
 * @method User setId(int $id);
 *
 * @method string getName();
 * @method User setName(string $name);
 *
 * @method string getPassword();
 * @method User setPassword(string $password);
 *
 * @method string getFirstName();
 * @method User setFirstName(string $name);
 *
 * @method string getLastName();
 * @method User setLastName(string $name);
 *
 * @method int getRole();
 * @method User setRole(int $role);
 *
 * @package SixQuests\Domain\Model
 */
class User
{
    use RichModelTrait;

    public const TABLE = 'users';

    // пользователь является админом.
    private const ROLE_ADMIN = 1;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var int
     */
    protected $role;

    /**
     * Пользователь админ?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}