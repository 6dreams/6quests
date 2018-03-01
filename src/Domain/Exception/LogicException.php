<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Exception;

/**
 * Class LoginException
 */
class LogicException extends \Exception
{
    /**
     * LoginException constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
