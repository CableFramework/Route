<?php

namespace Cable\Routing\Interfaces;

use Cable\Routing\RouteCollection;

/**
 * Interface MatcherInterface
 * @package Cable\Routing\Interfaces
 */
interface MatcherInterface
{

    /**
     * @param RequestInterface $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(RequestInterface $request, RouteCollection $collection);
}