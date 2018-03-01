<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DTO\Query;
use SixQuests\Domain\Model\User;

/**
 * Class DatabaseUserTransformer
 */
class DatabaseUserTransformer extends AbstractDatabaseTransformer
{
    /**
     * Преобразовать массив в пользователя.
     *
     * @param array $data
     *
     * @return User
     */
    public function transform(array $data): User
    {
        return (new User())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setFirstName($data['firstname'] ?? '')
            ->setLastName($data['lastname'] ?? '')
            ->setPassword($data['password'] ?? '')
            ->setRole($data['role'] ?? 0);
    }

    /**
     * {@inheritdoc}
     * @param User $user
     */
    public function detransform($user): Query
    {
        return $this
            ->addField('name', $user->getName())
            ->addField('firstname', $user->getFirstName())
            ->addField('lastname', $user->getLastName())
            ->addField('role', $user->getRole())
            ->addField('password', $this->getPassword($user))
            ->build(User::TABLE, $user->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * Хэшация пароля.
     *
     * @param User $user
     *
     * @return string
     */
    private function getPassword(User $user): string
    {
        $password = $user->getPassword() ?? '';

        if (\strlen($password) !== 32) {
            return \md5($password);
        }

        return $password;
    }
}
