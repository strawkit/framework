<?php

namespace StrawKit\Framework\Locators;

use ReflectionClass;
use ReflectionMethod;

class MethodLocator
{
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

            if (in_array($method->getName(), ['before', 'after'])) {
                continue;
            }

            $methods[] = $method;
        }

        return $methods;
    }
}