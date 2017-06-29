<?php

namespace Cable\Routing;


use Cable\Routing\Exceptions\LoaderException;
use Cable\Routing\Exceptions\RouteNotFoundException;
use Cable\Routing\Interfaces\LoaderInterface;
use Cable\Routing\Interfaces\MatcherInterface;
use Cable\Container\Annotations\Provider;
use Cable\Routing\Interfaces\RequestInterface;

/**
 * Class Routing
 * @package Cable\Routing
 * @Provider({"Cable\Routing\Providers\AnnotationServiceProvider"})
 */
class Routing
{

    // controller value
    const CONTROLLER = '__controller';

    const DEFAULT_REGEX = '[A-z0-9*?]+';

    /**
     * @var RouteCollection
     */
    private $collection;


    /**
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * @var Request
     */
    private $request;

    /**
     *
     * Routing constructor.
     * @param RequestInterface $request
     * @param RouteCollection $collection
     * @param MatcherInterface $matcher
     */
    public function __construct(RequestInterface $request, RouteCollection $collection, MatcherInterface $matcher)
    {
        $this->collection = $collection;
        $this->matcher = $matcher;
        $this->request = $request;
    }


    /**
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function handle(){
         $handled = $this->matcher->match($this->request, $this->collection);

        if ( !$handled) {
            throw new RouteNotFoundException(
                sprintf('there is not route matched with %s', $this->request->getUri())
            );
        }


        return $handled;
    }

    /**
     * @param LoaderInterface $loader
     * @return $this
     * @throws LoaderException when loader did not return a route collection
     */
    public function loadFromLoader(LoaderInterface $loader){
        $collection = $loader->load();

        if ( !$collection instanceof RouteCollection) {
            throw new LoaderException(
                sprintf('%s loader did not return a route collection', get_class($loader))
            );
        }

        $this->collection->addCollection(
            $collection
        );

        return $this;
    }
}
