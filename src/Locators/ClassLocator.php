<?php

namespace StrawKit\Framework\Locators;


use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;
use StrawKit\Framework\Testing\TestCase;

class ClassLocator
{
    /**
     * @param string $path
     * @return \ReflectionClass[]
     * @throws \ReflectionException
     */
    public static function list(string $path): array
    {
        $ast = (new BetterReflection())->astLocator();
        $reflector = new ClassReflector(new AggregateSourceLocator([
            new DirectoriesSourceLocator([__DIR__ . '/../Testing', $path], $ast),
        ]));

        $classes = [];

        foreach ($reflector->getAllClasses() as $class) {
            if ($class->isSubclassOf(TestCase::class)) {
                $classes[] = new \ReflectionClass($class->getName());
            }
        }

        return $classes;
    }
}