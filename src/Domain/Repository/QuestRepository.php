<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Quest;

/**
 * Class QuestRepository
 *
 * @method Quest getById(int $questId);
 * @method bool upsert(Quest $model);
 */
class QuestRepository extends AbstractRepository
{
    /**
     * Список почти завершённых квестов.
     *
     * @return array
     */
    public function getNotFinishedQuests(): array
    {
        return $this->getResults(
            'SELECT * FROM ~table WHERE state < :finished OR `date` > :few_days ORDER BY (state)',
            [
                'finished' => Quest::STATE_FINISHED,
                'few_days' => new \DateTime('now -3day')
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Quest::class;
    }
}
