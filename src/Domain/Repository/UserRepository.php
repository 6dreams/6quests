<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\User;

/**
 * Class UserRepository
 *
 * @method User getById(int $id);
 * @method bool upsert(User $model);
 */
class UserRepository extends AbstractRepository
{
    /**
     * Получить пользователя по логину или паролю.
     *
     * @param string $login
     * @param string $password
     *
     * @return null|User
     */
    public function getUserByLoginPassword(string $login, string $password): ?User
    {
        return $this->getResult(
            'SELECT ~fields FROM ~table WHERE name = :login AND password = :password',
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
