<?php

namespace Cable\Routing\Loader;


use Cable\Routing\Exceptions\LoaderException;
use Cable\Routing\Route;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\LoaderInterface;

class ArrayLoader implements LoaderInterface
{

    /**
     * @var array
     */
    private $array;

    /**
     * ArrayLoader constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * returns all loaded routes
     *
     * @throws LoaderException
     * @return RouteCollection
     */
    public function load()
    {
        return $this->loadFromArray($this->array);
    }

    /**
     * @param array $array
     * @throws LoaderException
     * @return RouteCollection|Route
     */
    private function loadFromArray(array $array)
    {
        if (isset($array['group']) && $array['group'] === true) {

            $group = $this->prepareGroupInstance($array);


            foreach ($array as $item => $value) {

                // we need an array to process, so just skip the other
                if ( ! is_array($value)) {
                    continue;
                }

                $handle = $this->loadFromArray($value);

                if ($handle instanceof RouteCollection) {
                    $group->addCollection($handle);
                } else {
                    $group->addRoute($handle);
                }
            }

            return $group;
        } else {
            return $this->prepareRouteInstance($array);
        }
    }

    /**
     * @param array $array
     * @return RouteCollection
     */
    private function prepareGroupInstance(array $array)
    {
        $collection = new RouteCollection();

        if (isset($array['prefix'])) {
            $collection->setPrefix($array['prefix']);
        }

        if (isset($array['scheme'])) {
            $collection->setScheme($array['scheme']);
        }

        if (isset($array['methods'])) {
            $collection->setMethods($array['methods']);
        }

        if (isset($array['host'])) {
            $collection->setHost($array['host']);
        }

        if (isset($array['defaults'])) {
            $collection->setDefaults($array['defaults']);
        }

        if (isset($array['requirements'])) {
            $collection->setRequirements($array['requirements']);
        }

        return $collection;
    }

    /**
     * @param array $route
     * @return Route
     * @throws LoaderException
     */
    private function prepareRouteInstance(array $route)
    {
        if ( ! isset($route['path'])) {
            throw new LoaderException(
                'You must provide an path key'
            );
        }

        $routeInstance = new Route($route['path']);

        if (isset($route['host'])) {
            $routeInstance->setHost($route['host']);
        }

        if (isset($route['scheme'])) {
            $routeInstance->setScheme($route['scheme']);
        }

        if (isset($route['methods'])) {
            $routeInstance->setMethods($route['methods']);
        }

        if (isset($route['defaults'])) {
            $routeInstance->setMethods($route['defaults']);
        }

        if (isset($route['requirements'])) {
            $routeInstance->setRequirements($route['requirements']);
        }

        return $routeInstance;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @param array $array
     * @return ArrayLoader
     */
    public function setArray(array $array)
    {
        $this->array = $array;

        return $this;
    }
}
