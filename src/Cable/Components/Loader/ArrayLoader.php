<?php

namespace Cable\Routing\Loader;


use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\LoaderInterface;

class ArrayLoader implements LoaderInterface
{

    /**
     * @var array
     */
    private $array;

    /**
     * ArrayLoader constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * returns all loaded routes
     *
     * @return RouteCollection
     */
    public function load()
    {

    }
}
