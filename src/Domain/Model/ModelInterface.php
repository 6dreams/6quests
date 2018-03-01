<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Model;

/**
 * Interface ModelInterface
 */
interface ModelInterface
{
    public const RELATION_ONE2ONE = 1;
    public const RELATION_ONE2MANY = 2;
}
