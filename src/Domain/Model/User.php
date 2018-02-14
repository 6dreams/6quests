<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Traits\RelationTrait;

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
    use RichModelTrait, RelationTrait;

    public const TABLE = 'users';

    public const FIELDS = ['id', 'name', 'password', 'firstname', 'lastname', 'role'];

    // пользователь является админом.
    public const ROLE_ADMIN = 1;
    public const ROLE_USER  = 0;

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