<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Repository;

use SixQuests\Database\Driver;

abstract class AbstractRepository
{
    /**
     * @var Driver
     */
    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }
}
