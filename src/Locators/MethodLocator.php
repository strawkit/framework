<?php

namespace StrawKit\Framework\Locators;

use ReflectionClass;
use ReflectionMethod;

class MethodLocator
{
    protected static $hidden = [
        '__construct', '__destruct', '__call', '__callStatic', '__get',
        '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString',
        '__invoke', '__set_state', '__clone', '__debugInfo', 'before', 'after'
    ];

    /**
     * @param ReflectionClass $class
     * @return ReflectionMethod[]
     */
    public static function list(ReflectionClass $class): array
    {
        $methods = [];

        foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isStatic()) {
                continue;
            }

            if (in_array($method->getName(), static::$hidden)) {
                continue;
            }

            $methods[] = $method;
        }

        return $methods;
    }
}