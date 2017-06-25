<?php

namespace Cable\Routing\Interfaces;

use Cable\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface MatcherInterface
 * @package Cable\Routing\Interfaces
 */
interface MatcherInterface
{

    /**
     * @param Request $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function match(Request $request, RouteCollection $collection);
}