<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

use SixDreams\RichModel\Traits\RichModelTrait;

/**
 * Class Quest
 *
 * @method int getId();
 * @method Quest setId(int $id);
 *
 * @method string getName();
 * @method Quest setName(string $name);
 *
 * @method \DateTime getDate();
 * @method Quest setDate(\DateTime $date);
 *
 * @method int getState();
 * @method Quest setState(int $state);
 *
 * @package SixQuests\Domain\Model
 */
class Quest
{
    use RichModelTrait;

    public const TABLE = 'quests';

    public const STATE_UNKNOWN  = 0;
    public const STATE_ACTIVE   = 5;
    public const STATE_FINISHED = 10;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $state;

    /**
     * Текстовое описание состояния.
     *
     * @return string
     */
    public function getStateName(): string
    {
        switch ($this->state) {
            case self::STATE_UNKNOWN:
                return 'не начат';
            case self::STATE_ACTIVE:
                return 'начат';
            default:
                return 'завершён';
        }
    }
}