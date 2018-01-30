<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\User;

/**
 * Class UserRepository
 * @package SixQuests\Domain\Repository
 */
class UserRepository extends AbstractRepository
{
    /**
     * @var string Название таблицы в базе.
     */
    protected static $table = 'users';

    /**
     * Получить пользователя по его ID.
     *
     * @param int $id
     * @return null|User
     */
    public function getUserById(int $id): ?User
    {
        return $this->getResult(
            'SELECT * FROM ~table WHERE id = :id',
            ['id' => $id]
        );
    }

    /**
     * Получить пользователя по логину или паролю.
     *
     * @param string $login
     * @param string $password
     * @return null|User
     */
    public function getUserByLoginPassword(string $login, string $password): ?User
    {
        return $this->getResult(
            'SELECT * FROM ~table WHERE name = :login AND password = :password',
            [ 'login' => $login, 'password' => \md5($password) ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return User::class;
    }
}
