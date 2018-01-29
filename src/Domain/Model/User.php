<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class User
 *
 * @method int getId();
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
 * @package SixQuests\Domain\Model
 */
class User
{
    use RichModelTrait;

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
}