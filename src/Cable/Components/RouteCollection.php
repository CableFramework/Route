<?php
/**
 * Created by PhpStorm.
 * User: My
 * Date: 06/25/2017
 * Time: 05:42
 */

namespace Cable\Routing;


class RouteCollection
{

    /**
     * @var array
     */
    private $routes;


    /**
     * @param Route $route
     * @return Route
     */
    public function addRoute(Route $route){
       return $this->routes[] = $route;
    }

    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return RouteCollection
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;

        return $this;
    }
}