<?php

namespace StrawKit\Framework;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use StrawKit\Framework\Testing\After;
use StrawKit\Framework\Testing\Before;

class Executioner
{
    public static function execute(ReflectionClass $class, ReflectionMethod $method, $config = [])
    {
        $instance = $class->newInstance($config);

        if ($class->implementsInterface(Before::class)) {
            call_user_func_array([$instance, 'before'], []);
        }

        try {
            $method->invoke($instance);
        } catch (Exception $exception) {

        } finally {

        }

        if ($class->implementsInterface(After::class)) {
            call_user_func_array([$instance, 'after'], []);
        }
    }
}