<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;
use SixQuests\Domain\Model\Traits\RelationTrait;

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
 * @method int getQuestId();
 * @method Team setQuestId(int $quest);
 *
 * @package SixQuests\Domain\Model
 */
class Team
{
    use RichModelTrait, RelationTrait;

    public const TABLE = 'teams';

    public const FIELDS = ['id', 'name', 'number', 'color', 'quest'];

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
    protected $questId;

    /**
     * @return array|mixed
     */
    public function getQuest()
    {
        return $this->getRelation('');
    }
}
