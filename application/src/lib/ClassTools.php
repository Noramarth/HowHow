<?php

namespace App\lib;

class ClassTools
{
    /**
     * @param $class
     */
    public static function getBaseClassName($class): string
    {
        return array_pop(explode('\\', get_class($class)));
    }

    public static function getBaseMethodName(string $FullyQualifiedMethodName): string
    {
        $staticMethod = array_pop(explode('\\', $FullyQualifiedMethodName));

        return substr(strstr($staticMethod, '::', false), 2);
    }
}
