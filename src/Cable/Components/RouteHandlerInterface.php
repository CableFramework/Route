<?php
/**
 * Created by PhpStorm.
 * User: My
 * Date: 06/04/2017
 * Time: 10:16
 */

namespace Cable\Routing;


interface RouteHandlerInterface
{

    /**
     * @return RouteDispatcher
     */
    public function handle();
}
