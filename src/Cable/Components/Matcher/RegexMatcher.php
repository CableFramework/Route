<?php

namespace Cable\Routing\Matcher;

use Cable\Routing\HandledRoute;
use Cable\Routing\MatcherRequestAware;
use Cable\Routing\Preparer\RegexPrepare;
use Cable\Routing\Route;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\MatcherInterface;
use Cable\Routing\Interfaces\RequestInterface;

/**
 * Class RegexMatcher
 * @package Cable\Routing\Matcher
 */
class RegexMatcher implements MatcherInterface
{

    use MatcherRequestAware, RegexAwareTrait;


    /**
     * @var array
     */
    private $neededParameters = [
        'handled_url',
        'scheme_id',
    ];

    /**
     * @param RequestInterface $request any psr-7 interface
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(RequestInterface $request, RouteCollection $collection)
    {
        $this->request = $request;

        // get method and requested uri,
        $routes = $collection->getRoutes();
        $method = $this->request->getMethod();
        $requestUri = $this->getRequestUri();
        $scheme = $this->request->getScheme();

        foreach ($routes as $route) {

            // if requested methods don't match route's scheme skip this route,
            if (!in_array($scheme, $route->getScheme(), true)) {
                continue;
            }

            // if requested methods don't match routes methods skip this route,
            if ( ! in_array($method, $route->getMethods(), true)) {
                continue;
            }

            // prepare routes for matching
            // sets host and scheme
            $this->prepareRouteForMatching($route);

            // prepares regex string, might very complicated
            $regex = $this->prepareRegex($route);

            // lets check the regex is matching with called request
            if ( ! preg_match($regex, $requestUri, $matched)) {
                continue;
            }

            return new HandledRoute(
                $route,
                array_merge($this->cleanMatchedObject($matched), $route->getDefaults())
            );
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
