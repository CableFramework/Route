<?php
namespace Cable\Routing;

/**
 * Class RouteCollection
 * @package Cable\Routing
 */
class RouteCollection extends Route
{

    /**
     * @var string
     */
    private $prefix;



    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * RouteCollection constructor.
     * @param $uri
     * @param array $requirements
     */
    public function __construct($uri= '', array $requirements = [])
    {
        parent::__construct('', $requirements);
        $this->setPrefix($uri);
    }


    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return RouteCollection
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }


    /**
     * @param Route $route
     * @return Route
     */
    public function addRoute(Route $route){
        $name = $route->getName();

        if (null !== $name) {
            return $this->routes[$name] = $route;
        }

         return $this->routes[] = $route;
    }


    /**
     * get routes from inside a route collection
     *
     * @param RouteCollection $collection
     * @return $this
     */
    public function addCollection(RouteCollection $collection){
        $routes = $collection->getRoutes();

        $prefix = $collection->getPrefix();
        $host = $collection->getHost();
        $scheme = $collection->getScheme();
        $methods = $collection->getMethods();
        $default = $collection->getDefaults();
        $requirements = $collection->getRequirements();

        foreach ($routes as $route){

            if ($prefix !== '') {
                $route->setUri(
                    $prefix.$route->getUri()
                );
            }

            if(!empty($methods) && empty($route->getMethods())){
                $route->setMethods($methods);
            }


            if (!empty($scheme) && empty($route->getScheme())) {
                $route->setScheme($scheme);
            }


            if (!empty($host) && empty($route->getHost())) {
                $route->setHost($host);
            }

            if ( !empty($default)) {
                $route->setDefaults(
                    array_merge($default, $route->getDefaults())
                );
            }

            if ( !empty($requirements)) {
                $route->setRequirements(
                    array_merge($requirements, $route->getRequirements())
                );
            }



            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return object|bool
     */
    public function getRouteByName($name){
        if (isset($this->routes[$name])) {
            return $name;
        }

        foreach ($this->routes as $route){
            if ($route->getName() === $name) {
                return $route;
            }
        }

        return false;
    }




    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return RouteCollection
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;

        return $this;
    }


}