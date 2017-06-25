<?php

namespace Cable\Routing;

/**
 * Class Route
 * @package Cable\Routing
 */
class Route
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $requirements;


    /**
     * @var array
     */
    private $methods = [];

    /**
     * @var string
     */
    private $host;


    /**
     * @var array
     */
    private $scheme = ["http", "https"];

    /**
     * @var array
     */
    private $defaults = [];


    /**
     * Route constructor.
     * @param $uri
     * @param array $requirements
     */
    public function __construct($uri, array $requirements = [])
    {
        $this->setUri($uri);
        $this->requirements = $requirements;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Route
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Route
     */
    public function setUri($uri)
    {
        if (strlen($uri) > 0 && $uri[0] !== '/') {
            $uri = '/'. $uri;
        }

        $this->uri = $uri;

        return $this;
    }

    /**
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @param array $requirements
     * @return Route
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     * @return Route
     */
    public function setMethods($methods)
    {
        $this->methods = (array) $methods;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Route
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return array
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param array $schema
     * @return Route
     */
    public function setScheme(array $schema)
    {
        $this->scheme = $schema;

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     * @return Route
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }

}
