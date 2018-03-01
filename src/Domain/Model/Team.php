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
     * Team constructor.
     */
    public function __construct()
    {
        $this->createRelation(
            ModelInterface::RELATION_ONE2ONE,
            Quest::class,
            'questId',
            'SELECT * FROM &' . Quest::TABLE . ' WHERE id = :arg1'
        );
    }

    /**
     * Получить квест
     *
     * @return null|Quest
     */
    public function getQuest(): ?Quest
    {
        return $this->getRelation('questId');
    }
}
