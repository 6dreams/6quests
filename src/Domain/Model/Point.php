<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

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
 * @method int getUser();
 * @method Point setUser(int $id);
 *
 * @method int getQuest();
 * @method Point setQuest(int $id);
 *
 * @package SixQuests\Domain\Model
 */
class Point
{
    use RichModelTrait;

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
    protected $user;

    /**
     * @var int
     */
    protected $quest;
}
