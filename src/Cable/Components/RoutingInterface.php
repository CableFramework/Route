<?php
/**
 * Created by PhpStorm.
 * User: My
 * Date: 06/05/2017
 * Time: 05:06
 */

namespace Cable\Routing;

interface RoutingInterface
{
    /**
     * @param array $methods
     * @param string $uri
     * @param arrray $options
     * @return $this
     */
    public function match($methods, $uri, $options);

    /**
     * @param array $group
     * @param \Closure $callback
     * @return Routing
     */
    public function group($group, \Closure $callback);

    /**
     * defines a get route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function get($uri, $options);

    /**
     * defines a post route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function post($uri, $options);

    /**
     * defines a put route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function put($uri, $options);

    /**
     * defines a delete route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function delete($uri, $options);

    /**
     * defines a head route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function head($uri, $options);

    /**
     * defines a patch route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function patch($uri, $options);
}
