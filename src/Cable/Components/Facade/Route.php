<?php

namespace Cable\Routing\Facade;


use Cable\Facade\Facade;
use Cable\Routing\Routing;

/**
 * Class Route
 * @package Cable\Routing\Facade
 */
class Route extends Facade
{

    /**
     * return route facade
     *
     * @return string
     */
    public static function getFacadeClass()
    {
        return Routing::class;
    }
}