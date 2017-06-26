<?php
namespace Cable\Routing\Loader;

use Cable\Annotation\ExecutedBag;
use Cable\Routing\Exceptions\AnnotationLoaderException;
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

        $this->throwExceptionConstructorRoutes();

    }


    private function throwExceptionConstructorRoutes(){
        if ($this->annotations->get('Route')) {
            throw new AnnotationLoaderException(
                'You cant have a route annotation in class doc'
            );
        }

        if ($this->annotations->get('methods\__construct\Route')) {
            throw new AnnotationLoaderException(
                'You cant have a route annotation in constructor method'
            );
        }
    }
}
