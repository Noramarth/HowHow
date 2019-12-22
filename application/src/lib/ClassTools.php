<?php


namespace App\lib;


class ClassTools
{
    /**
     * @param $class
     * @return string
     */
    public static function getBaseClassName($class): string
    {
        return array_pop(explode('\\', get_class($class)));
    }

    /**
     * @param string $FullyQualifiedMethodName
     * @return string
     */
    public static function getBaseMethodName(string $FullyQualifiedMethodName): string
    {
        $staticMethod = array_pop(explode('\\', $FullyQualifiedMethodName));
        return substr(strstr($staticMethod, '::', false), 2);
    }
}