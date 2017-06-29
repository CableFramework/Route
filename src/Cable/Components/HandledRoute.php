<?php

namespace Cable\Routing;

/**
 * Class HandledRoute
 * @package Cable\Routing
 */
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
     * @var string
     */
    private $controller;


    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $handledUri;

    /**
     * HandledRoute constructor.
     * @param Route $route
     * @param array $parameters
     */
    public function __construct(Route $route, array $parameters = [])
    {
        $this->setRoute($route)
            ->setParameters($parameters);

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
        if (isset($parameters['handled_uri'])) {
            $this->handledUri = $parameters['handled_uri'];
            unset($parameters['handled_uri']);
        }

        if (isset($parameters['scheme_id'])) {
            $this->scheme = $parameters['scheme'];
            unset($parameters['scheme']);
        }

        if (isset($parameters[Routing::CONTROLLER])) {
            $this->controller = $parameters[Routing::CONTROLLER];
            unset($parameters[Routing::CONTROLLER]);
        }

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     * @return HandledRoute
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return HandledRoute
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getHandledUri()
    {
        return $this->handledUri;
    }

    /**
     * @param string $handledUri
     * @return HandledRoute
     */
    public function setHandledUri($handledUri)
    {
        $this->handledUri = $handledUri;

        return $this;
    }
}
