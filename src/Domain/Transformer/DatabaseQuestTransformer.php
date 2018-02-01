<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Transformer;

use SixQuests\Database\DTO\Query;
use SixQuests\Domain\Model\Quest;

/**
 * Class DatabaseQuestTransformer
 * @package SixQuests\Domain\Transformer
 */
class DatabaseQuestTransformer extends AbstractDatabaseTransformer
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
            ->setDate($data['date'] ? new \DateTime($data['date']) : null)
            ->setState($data['state'] ?? Quest::STATE_UNKNOWN);
    }

    /**
     * {@inheritdoc}
     * @param Quest $quest
     */
    public function detransform($quest): Query
    {
        return $this
            ->addField('name', $quest->getName())
            ->addField('date', $quest->getDate())
            ->addField('state', $quest->getState())
            ->build(Quest::TABLE, $quest->getId());
    }


    /**
     * {@inheritdoc}
     */
    public function getModel(): string
    {
        return Quest::class;
    }
}
