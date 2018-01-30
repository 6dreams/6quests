<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;
use SixQuests\Domain\Repository\QuestRepository;

/**
 * Class QuestManager
 * @package SixQuests\Domain\Manager
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
}
