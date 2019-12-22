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
}