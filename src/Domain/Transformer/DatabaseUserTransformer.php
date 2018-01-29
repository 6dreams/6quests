<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Domain\Model\User;

/**
 * Class DatabaseUserTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseUserTransformer implements DatabaseTransformerInterface
{
    /**
     * Преобразовать массив в пользователя.
     *
     * @param array $data
     * @return User
     */
    public function transform(array $data): User
    {
        return (new User())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setFirstName($data['firstname'] ?? '')
            ->setLastName($data['lastname'] ?? '')
            ->setPassword($data['password'] ?? '');
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return User::class;
    }
}