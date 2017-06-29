<?php

namespace Cable\Routing\Matcher;


use Cable\Routing\HandledRoute;
use Cable\Routing\MatcherRequestAware;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\MatcherInterface;
use Cable\Routing\Interfaces\RequestInterface;

/**
 * Class StaticMatcher
 * @package Cable\Routing\Matcher
 */
class StaticMatcher implements MatcherInterface
{

    use RegexAwareTrait, MatcherRequestAware;
    /**
     * @param RequestInterface $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(RequestInterface $request, RouteCollection $collection)
    {
        $this->request = $request;

        $routes = $collection->getRoutes();

        $scheme = $request->getScheme();
        $method = $request->getMethod();


        foreach ($routes as $route){

            if (!in_array($scheme, $route->getScheme(), true)) {
                continue;
            }


            if (!in_array($method, $route->getMethods(), true)) {
                continue;
            }

            if ($this->hasRegexCommand($route->getHost()) ||$this->hasRegexCommand($route->getUri())) {
                continue;
            }


            if ($request->getPath() === $route->getUri()) {
                $defaults = $route->getDefaults();
                $defaults['handled_url'] = $this->getRequestUri();
                $defaults['scheme_id'] = $scheme;


                return new HandledRoute($route, $defaults);
            }
        }

        return false;
    }
}
