<?php

namespace Cable\Routing;


use Cable\Routing\Interfaces\MatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class Matcher implements MatcherInterface
{
    /**
     * @var RouteCollection
     */
    private $collection;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $neededParameters = [
        'handled_url',
        'scheme_id',
    ];

    /**
     * Matcher constructor.
     * @param Request $request
     * @param RouteCollection $collection
     */
    public function __construct(Request $request, RouteCollection $collection)
    {
        $this->collection = $collection;
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function match()
    {
        // get method and requested uri,
        $routes = $this->collection->getRoutes();
        $method = $this->request->getMethod();
        $requestUri = $this->request->getUri();

        foreach ($routes as $route) {

            // if requested methods don't match routes methods skip this route,
            if ( ! in_array($method, $route->getMethods(), true)) {
                continue;
            }

            // prepare routes for matching
            // sets host and scheme
            $this->prepareRouteForMatching($route);

            // if we do not need use regex here we return back from here
            if ( ! $this->neededRegex($route) && $requestUri === $this->prepareStaticUri($route)) {
                return $route;
            }

            // prepares regex string, might very complicated
            $regex = $this->prepareRegex($route);

            // lets check the regex is matching with called request
            if ( ! preg_match($regex, $requestUri, $matched)) {
                continue;
            }


            $parameters  = array_merge($this->cleanMatchedObject($matched), $route->getDefaults());

            return new HandledRoute($route, $parameters);
        }
    }


    /**
     * @param array $matched
     * @return array
     */
    private function cleanMatchedObject(array $matched)
    {
        $matched['handled_url'] = $matched[0];

        return array_intersect_key($matched, array_flip($this->neededParameters));
    }

    /**
     * @param Route $route
     * @return string
     */
    private function prepareRegex(Route $route)
    {
        $preparer = new RegexPrepare($route);
        $prepared = $preparer->prepare();

        $this->neededParameters = array_merge($this->neededParameters, $preparer->getParameters());

        return $prepared;
    }

    /**
     * @param Route $route
     * @return string
     */
    private function prepareStaticUri(Route $route)
    {
        return sprintf(
            '%s://%s%s',
            $route->getScheme()[0],
            $route->getHost(),
            $route->getUri()
        );
    }

    /**
     * @param Route $route
     * @return bool
     */
    private function neededRegex(Route $route)
    {
        if (count($route->getScheme()) > 1) {
            return true;
        }

        if (count($route->getRequirements()) > 1) {
            return true;
        }


        return false;
    }

    /**
     * sets host and scheme variables from request if they did not provided by user
     *
     * @param Route $route
     */
    private function prepareRouteForMatching(Route $route)
    {
        $host = $route->getHost();

        if (null === $host) {
            $route->setHost(
                $this->request->getHost()
            );
        }

        $scheme = $route->getScheme();

        if (null === $scheme) {
            $route->setScheme(
                array(
                    $this->request->getScheme(),
                )
            );
        }
    }
}
