<?php

namespace Cable\Routing;


use Cable\Routing\Exceptions\LoaderException;
use Cable\Routing\Exceptions\RouteNotFoundException;
use Cable\Routing\Interfaces\LoaderInterface;
use Cable\Routing\Interfaces\MatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Cable\Container\Annotations\Provider;

/**
 * Class Routing
 * @package Cable\Routing
 * @Provider({"Cable\Routing\Providers\AnnotationServiceProvider"})
 */
class Routing
{

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
     * Routing constructor.
     * @param Request $request
     * @param RouteCollection $collection
     * @param MatcherInterface $matcher
     */
    public function __construct(Request $request, RouteCollection $collection, MatcherInterface $matcher)
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
