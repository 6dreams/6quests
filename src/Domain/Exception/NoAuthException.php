<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Exception;

/**
 * Class NoAuthException
 * @package SixQuests\Domain\Exeception
 */
class NoAuthException extends \Exception
{
    /**
     * NoAuthException constructor.
     */
    public function __construct()
    {
        parent::__construct('');
    }
}
