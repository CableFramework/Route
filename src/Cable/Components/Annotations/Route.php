<?php

namespace Cable\Routing\Annotations;

/**
 * Class Route
 * @package Cable\Routing\Annotations
 * @Annotation()
 * @Name("Route")
 */
class Route
{

    /**
     * @var string
     * @Annotation()
     *
     * @Required()
     */
    public $uri;

    /**
     * @var string
     * @Annotation()
     *
     * @Default("GET")
     */
    public $methods;

    /**
     * @var string
     * @Annotation()
     */
    public $name;


    /**
     * @var string
     * @Annotation()
     *
     */
    public $host;

    /**
     * @var array
     * @Annotation()
     *
     */
    public $scheme;


    /**
     * @var array
     * @Annotation()
     *
     */
    public $defaults;
}
