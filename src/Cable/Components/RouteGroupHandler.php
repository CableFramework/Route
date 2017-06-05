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
        }

        if (isset($options['subdomain'])) {
            $this->resolveSubdomain($this->collection, $options['subdomain']);
        }

        return $this->collection;
    }

    /**
     * @param RouteCollection $route
     * @param array $subdomain
     */
    private function resolveSubdomain(RouteCollection $route, array $subdomain)
    {
        if (isset($subdomain['domain'])) {
            $route->setHost($subdomain['domain']);

            if (isset($subdomain['catch'])) {
                $catch = $subdomain['catch'];

                foreach ($catch as $key => $val){
                    $route->addRequirements(array(
                        $key => $val
                    ));
                }
            }
        }
    }

}
