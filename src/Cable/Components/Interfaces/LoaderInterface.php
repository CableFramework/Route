<?php

namespace Cable\Routing\Interfaces;

use Cable\Routing\RouteCollection;

/**
 * Interface LoaderInterface
 * @package Cable\Routing\Interfaces
 */
interface LoaderInterface
{

    /**
     * returns all loaded routes
     *
     * @return RouteCollection
     */
    public function load();

}
