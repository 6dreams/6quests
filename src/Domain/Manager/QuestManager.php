<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Domain\Model\Quest;
use SixQuests\Domain\Repository\QuestRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class QuestManager
 */
class QuestManager
{
    /**
     * @var QuestRepository
     */
    private $quests;

    /**
     * QuestManager constructor.
     *
     * @param QuestRepository $repository
     */
    public function __construct(QuestRepository $repository)
    {
        $this->quests = $repository;
    }

    /**
     * Список квестов, которые нужно отобразить админу.
     *
     * @return array
     */
    public function getAdminQuests(): array
    {
        return $this->quests->getNotFinishedQuests();
    }

    /**
     * Получить квест по его ID.
     *
     * @param int $id
     *
     * @return Quest
     */
    public function getQuest(int $id): Quest
    {
        $quest = $this->quests->getById($id);

        if ($quest) {
            return $quest;
        }

        throw new NotFoundHttpException();
    }

    /**
     * Начать квест.
     *
     * @param Quest $quest
     */
    public function startQuest(Quest $quest): void
    {
        $this->quests->upsert(
            $quest
                ->setState(Quest::STATE_ACTIVE)
                ->setDate(new \DateTime())
        );
    }

    /**
     * Завершить квест.
     *
     * @param Quest $quest
     */
    public function finishQuest(Quest $quest): void
    {
        $this->quests->upsert($quest->setState(Quest::STATE_FINISHED));
    }
}
