<?php

namespace Cable\Routing\Loader;

use Cable\Annotation\Annotation;
use Cable\Annotation\ExecutedBag;
use Cable\Annotation\Parser;
use Cable\Routing\Annotations\Group;
use Cable\Routing\Annotations\Route;
use Cable\Routing\Exceptions\AnnotationLoaderException;
use Cable\Routing\Exceptions\LoaderException;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\LoaderInterface;

/**
 * Class AnnotationLoader
 * @package Cable\Routing\Loader
 */
class AnnotationLoader implements LoaderInterface
{

    /**
     * @var ExecutedBag
     */
    private $annotations;

    /**
     * @var RouteCollection
     */
    private $globalGroup;

    /**
     * @var \Cable\Routing\Route[]
     */
    private $routes;

    /**
     * AnnotationLoader constructor.
     * @param ExecutedBag $bag
     */
    public function __construct(ExecutedBag $bag = null)
    {
        $this->annotations = $bag;
    }


    /**
     * returns all loaded routes
     *
     * @throws LoaderException
     * @return RouteCollection
     */
    public function load()
    {


        $this->throwExceptionConstructorRoutes();
        $this->addGlobalGroup();
        $this->loopRoutes();

        if (null !== $this->globalGroup) {
           $collection = $this->addFromGlobalGroup();
        }else{
            $collection = $this->addFromRoutes();
        }


        return $collection;
    }


    /**
     * @return RouteCollection
     */
    private function addFromRoutes(){
        $collection = new RouteCollection();

        foreach ($this->routes as $route){
            $collection->addRoute($route);
        }

        return $collection;
    }
    /**
     * @return RouteCollection
     */
    private function addFromGlobalGroup(){
        $group = $this->globalGroup;

        foreach ($this->routes as $route){
            $group->addRoute($route);
        }

        return (new RouteCollection())->addCollection($group);
    }
    /**
     *  loop all routes
     */
    private function loopRoutes()
    {
        $methods = $this->annotations->methods()->getObjects();

        foreach ($methods as $method) {
            if ( ! isset($method['Route'])) {
                continue;
            }

            $routes = $method['Route'][0];

            /**
             * @var Route[] $routes
             */
            foreach ($routes as $route) {
                $this->routes[] = $this->prepareRouteInstance($route);
            }
        }

    }

    /**
     * save global group
     */
    private function addGlobalGroup()
    {
        if ($group = $this->annotations->Group()) {
            $this->globalGroup = $this->prepareGroupInstance($group[0]);
        }

    }


    /**
     * @param Route $item
     * @return \Cable\Routing\Route
     */
    private function prepareRouteInstance(Route $item)
    {
        $route = new \Cable\Routing\Route($item->uri, $item->requirements);

        $route->setName($item->name)
            ->setMethods($item->methods)
            ->setHost($item->host)
            ->setScheme($item->scheme);

        if (null !== $item->defaults) {
            $route->setDefaults($item->defaults);
        }


        return $route;
    }

    /**
     * @param Group $item
     * @return RouteCollection
     */
    private function prepareGroupInstance(Group $item)
    {
        $newGroup = new RouteCollection($item->prefix, $item->requirements);

        if ( ! empty($item->defaults)) {
            $newGroup->setDefaults(
                $item->defaults
            );
        }

        if ( ! empty($item->methods)) {
            $newGroup->setMethods($item->methods);
        }

        if ( ! empty($item->host)) {
            $newGroup->setHost($item->host);
        }

        if ( ! empty($item->scheme)) {
            $newGroup->setScheme($item->scheme);
        }
        


        return $newGroup;
    }


    /**
     * @throws AnnotationLoaderException
     */
    private function throwExceptionConstructorRoutes()
    {
        if ($this->annotations->Route()) {
            throw new AnnotationLoaderException(
                'You cant have a route annotation in class doc'
            );
        }


        if ($this->annotations->methods()->__construct()) {
            throw new AnnotationLoaderException(
                'You cant have a route annotation in constructor method'
            );
        }
    }
}
