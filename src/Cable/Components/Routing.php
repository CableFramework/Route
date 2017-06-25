<?php

namespace Cable\Routing;


class Routing
{

    const DEFAULT_REGEX = '[A-z0-9*?]+';
    /**
     * @var RouteCollection
     */
    private $collection;


    /**
     * Routing constructor.
     * @param RouteCollection $collection
     */
    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

}
