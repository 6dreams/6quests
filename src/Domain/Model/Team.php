<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class Team
 *
 * @method int getId();
 * @method Team setId(int $id);
 *
 * @method string getName();
 * @method Team setName(string $name);
 *
 * @method int getNumber();
 * @method Team setNumber(int $id);
 *
 * @method string getColor();
 * @method Team setColor(string $color);
 *
 * @method int getQuest();
 * @method Team setQuest(int $quest);
 *
 * @package SixQuests\Domain\Model
 */
class Team
{
    use RichModelTrait;

    public const TABLE = 'teams';

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
    protected $number;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var int
     */
    protected $quest;
}
