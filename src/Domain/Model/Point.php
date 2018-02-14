<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Traits\RelationTrait;

/**
 * Class Point
 *
 * @method int getId();
 * @method Point setId(int $id);
 *
 * @method string getName();
 * @method Point setName(string $name);
 *
 * @method int getTimeLimit();
 * @method Point setTimeLimit(int $minutes);
 *
 * @method int getHints();
 * @method Point setHints(int $amount);
 *
 * @method int getHintCost();
 * @method Point setHintCost(int $cost);
 *
 * @method int getSkipCost();
 * @method Point setSkipCost(int $cost);
 *
 * @method int getUserId();
 * @method Point setUserId(int $id);
 *
 * @method int getQuestId();
 * @method Point setQuestId(int $id);
 *
 * @package SixQuests\Domain\Model
 */
class Point implements ModelInterface
{
    use RichModelTrait, RelationTrait;

    public const TABLE = 'points';

    public const FIELDS = ['id', 'name', 'time_limit', 'hints', 'hint_cost', 'skip_cost', 'user_id', 'quest_id'];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $timeLimit;

    /**
     * @var int
     */
    protected $hints;

    /**
     * @var int
     */
    protected $hintCost;

    /**
     * @var int
     */
    protected $skipCost;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $questId;

    /**
     * Point constructor.
     */
    public function __construct()
    {
        $this
            ->createRelation(self::RELATION_ONE2ONE, User::class, 'userId', 'SELECT * FROM &' . User::TABLE . ' WHERE id = :arg1')
            ->createRelation(self::RELATION_ONE2ONE, Quest::class, 'questId', 'SELECT * FROM &' . Quest::TABLE . ' WHERE id = :arg1');
    }

    /**
     * Получить юзера.
     *
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->getRelation('userId');
    }

    /**
     * Получить квест.
     *
     * @return null|Quest
     */
    public function getQuest(): ?Quest
    {
        return $this->getRelation('questId');
    }
}
