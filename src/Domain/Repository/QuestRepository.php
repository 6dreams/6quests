<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Domain\Model\Quest;

/**
 * Class QuestRepository
 * @package SixQuests\Domain\Repository
 */
class QuestRepository extends AbstractRepository
{
    /**
     * @var string Название таблицы в базе.
     */
    protected static $table = 'quests';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModel(): string
    {
        return Quest::class;
    }

    /**
     * Список почти завершённых квестов.
     *
     * @return array
     */
    public function getNotFinishedQuests(): array
    {
        return $this->getResults(
            'SELECT * FROM ~table WHERE (state < :finished) OR (state = :finished AND `date` > :few_days) ORDER BY (state)',
            [
                'finished' => Quest::STATE_FINISHED,
                'few_days' => new \DateTime('now -3day')
            ]
        );
    }
}
