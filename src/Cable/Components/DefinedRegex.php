<?php

namespace Cable\Routing;


class DefinedRegex
{

    /**
     * @var array
     */
    private static $defined;


    /**
     * @param string $name
     * @param $regex
     */
    public static function add($name, $regex, $default)
    {
        static::$defined[$name] = array($regex, $default);
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function has($name)
    {
        return isset(static::$defined[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        return static::$defined[$name];
    }
}
