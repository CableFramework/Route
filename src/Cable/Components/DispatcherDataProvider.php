<?php
/**
 * Created by PhpStorm.
 * User: My
 * Date: 06/04/2017
 * Time: 08:19
 */

namespace Cable\Routing;


class DispatcherDataProvider
{

    private $namespace;

    private $controller;

    private $method;

    public function __construct(
        $namespace,
        $controller,
        $method )
    {

        $this->namespace = $namespace;
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     * @return DispatcherDataProvider
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     * @return DispatcherDataProvider
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return DispatcherDataProvider
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

}
