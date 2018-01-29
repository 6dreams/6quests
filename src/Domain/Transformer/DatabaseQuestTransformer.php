<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DatabaseTransformerInterface;
use SixQuests\Domain\Model\Quest;

/**
 * Class DatabaseQuestTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseQuestTransformer implements DatabaseTransformerInterface
{
    /**
     * Преобразовать ответ базы в объект квеста.
     *
     * @param array $data
     * @return Quest
     */
    public function transform(array $data): Quest
    {
        return (new Quest())
            ->setId($data['id'] ?? 0)
            ->setName($data['name'] ?? '')
            ->setDate(new \DateTime($data['date']) ?? null)
            ->setState($data['id'] ?? Quest::STATE_UNKNOWN);
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Quest::class;
    }
}
