<?php

namespace Cable\Routing;


use Cable\Container\NotFoundException;
use Cable\Routing\Interfaces\RequestInterface;

class UrlGenerator
{
    /**
     * @var RouteCollection
     */
    private $collection;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * UrlGenerator constructor.
     * @param RouteCollection $collection
     */
    public function __construct(RouteCollection $collection, RequestInterface $request)
    {
        $this->collection = $collection;
        $this->request= $request;
    }

    /**
     * @param string $name the name of route
     * @param array $parameters
     * @return mixed|string
     * @throws NotFoundException
     */
    public function generate($name, array $parameters = []){
        $route = $this->collection->getRouteByName($name);

        if (false === $route) {
            throw new NotFoundException(
                sprintf(
                    '%s route not found',
                    $name
                )
            );
        }

        return $this->prepareUrl($route, $parameters);
    }

    /**
     * @param Route $route
     * @param array $parameters
     * @return mixed|string
     */
    private function prepareUrl(Route $route, array $parameters){
        // get host
        $host = null === $route->getHost() ? $this->request->getHost() : $route->getHost();

        $scheme = isset($parameters['scheme']) ?
            $parameters['scheme'] : $route->getScheme() ;

        // get first index if scheme is array
        $scheme = is_array($scheme) ? $scheme[0] : $scheme;

        $pathInfo = $route->getUri();

        if (isset($parameters['query_params'])) {
            $queryParamString = $this->prepareQueryParamString($parameters['query_params']);

            unset($parameters['query_params']);
        }


        $prepared = $this->replaceWithParameters(
            $scheme.'://'.$host.$pathInfo,
            $parameters
        );


        if (isset($queryParamString)) {
            $prepared .= '?'.$queryParamString;
        }

        return $prepared;
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function prepareQueryParamString(array $parameters){
        return http_build_query($parameters);
    }

    /**
     * @param string $string
     * @param array $parameters
     * @return mixed
     */
    private function replaceWithParameters($string, array $parameters){
        foreach ($parameters as $key => $parameter){
            $key = ':'.$key;

            $string = str_replace($key, $parameter, $string);
        }

        return $string;
    }
}
