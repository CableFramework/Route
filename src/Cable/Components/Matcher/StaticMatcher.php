<?php

namespace Cable\Routing\Matcher;


use Cable\Routing\HandledRoute;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\MatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StaticMatcher
 * @package Cable\Routing\Matcher
 */
class StaticMatcher implements MatcherInterface
{

    /**
     * @param Request $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(Request $request, RouteCollection $collection)
    {
        $routes = $collection->getRoutes();

        foreach ($routes as $route){



            if (!in_array($request->getMethod(), $route->getMethods(), true)) {
                continue;
            }


            if ($request->getPathInfo() === $route->getUri()) {
                return new HandledRoute($route, $route->getDefaults());
            }
        }

        return false;
    }
}