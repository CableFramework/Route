<?php
namespace Cable\Routing\Loader;

use Cable\Annotation\ExecutedBag;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\LoaderInterface;

/**
 * Class AnnotationLoader
 * @package Cable\Routing\Loader
 */
class AnnotationLoader implements LoaderInterface
{

    /**
     * @var ExecutedBag
     */
    private $annotations;

    /**
     * AnnotationLoader constructor.
     * @param ExecutedBag $bag
     */
    public function __construct(ExecutedBag $bag)
    {
        $this->annotations = $bag;
    }

    /**
     * returns all loaded routes
     *
     * @return RouteCollection
     */
    public function load()
    {
        // TODO: Implement load() method.
    }
}
