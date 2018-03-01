<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Specification;

/**
 * Class DateTimeSpecification
 */
class DateTimeSpecification
{
    /**
     * @var \DateTime
     */
    private $left;

    /**
     * @var \DateTime
     */
    private $right;

    /**
     * DateTimeSpecification constructor.
     *
     * @param \DateTime $left
     * @param \DateTime $right
     */
    public function __construct(\DateTime $left, \DateTime $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Даты одинаковые
     *
     * @return bool
     */
    public function equal(): bool
    {
        return $this->left->getTimestamp() === $this->right->getTimestamp();
    }

    /**
     * Левая меньше правой.
     *
     * @return bool
     */
    public function less(): bool
    {
        return $this->left->getTimestamp() < $this->right->getTimestamp();
    }

    /**
     * Левая больше правой.
     *
     * @return bool
     */
    public function more(): bool
    {
        return !$this->less();
    }
}
