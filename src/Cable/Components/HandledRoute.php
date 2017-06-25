<?php

namespace Cable\Routing;


class HandledRoute
{

    /**
     * @var Route
     */
    private $route;

    /**
     * @var array
     */
    private $parameters;

    /**
     * HandledRoute constructor.
     * @param Route $route
     * @param array $parameters
     */
    public function __construct(Route $route, array $parameters = [])
    {
        $this->route = $route;
        $this->parameters = $parameters;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param Route $route
     * @return HandledRoute
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return HandledRoute
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }
}
