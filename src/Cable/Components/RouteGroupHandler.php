<?php
namespace Cable\Routing;

use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteGroupHandler
 * @package Cable\Routing
 */
class RouteGroupHandler implements RouteHandlerInterface
{

    /**
     * @var RouteCollection
     */
    private $collection;

    /**
     * @var array
     */
    private $options;

    public function __construct(RouteCollection $collection,array $options)
    {
        $this->collection = $collection;
        $this->options= $options;
    }

    /**
     * @return RouteCollection
     */
    public function handle()
    {
        $options = $this->options;

        if (isset($options['scheme'])) {
            $this->collection->setSchemes($options['scheme']);

            // we don't need that anymore
            unset($options['scheme']);
        }

        if (isset($options['subdomain'])) {
            $this->resolveSubdomain($options['subdomain']);

            // we don't need that anymore
            unset($options['subdomain']);
        }


        // we got what we needed, we will pass everything else into defaults
        $this->collection->addDefaults($options);


        return $this->collection;
    }

    /**
     * @param RouteCollection $route
     * @param array $subdomain
     */
    private function resolveSubdomain( array $subdomain)
    {
        if (isset($subdomain['domain'])) {
            $this->collection->setHost($subdomain['domain']);

            if (isset($subdomain['catch'])) {
                $catch = $subdomain['catch'];

                foreach ($catch as $key => $val){
                    $this->collection->addRequirements(array(
                        $key => $val
                    ));
                }
            }
        }
    }

}
