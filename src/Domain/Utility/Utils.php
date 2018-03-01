<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Utility;

/**
 * Class Utils
 */
class Utils
{
    /**
     * Получить значение константы.
     *
     * @param mixed  $object
     * @param string $name
     *
     * @return mixed
     */
    public static function constant($object, string $name)
    {
        $ref = new \ReflectionClass($object);

        return $ref->getConstant($name);
    }
}
