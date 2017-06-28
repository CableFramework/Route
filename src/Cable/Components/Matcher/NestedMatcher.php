<?php

namespace Cable\Routing\Matcher;


use Cable\Routing\HandledRoute;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\RequestInterface;
use Cable\Routing\Interfaces\MatcherInterface;


class NestedMatcher implements MatcherInterface
{

    /**
     * @var array
     */
    private $matchers;

    /**
     * NestedMatcher constructor.
     * @param MatcherInterface[] ...$matchers
     */
    public function __construct(MatcherInterface ...$matchers)
    {
        $this->matchers = $matchers;
    }

    /**
     * @param RequestInterface $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(RequestInterface $request, RouteCollection $collection)
    {
         foreach ($this->matchers as $matcher){
              $handled = $matcher->match($request, $collection);

             if ($handled instanceof HandledRoute) {
                 return $handled;
             }
         }


         return false;
    }
}