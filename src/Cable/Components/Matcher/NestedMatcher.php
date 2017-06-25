<?php

namespace Cable\Routing\Matcher;


use Cable\Routing\HandledRoute;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\MatcherInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(Request $request, RouteCollection $collection)
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