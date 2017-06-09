<?php

namespace Cable\Routing;


use Cable\Config\Config;
use Cable\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class Routing implements RoutingInterface
{

    /**
     * @var Request
     */
    private $request;


    /**
     * @var Config
     */
    private $config;


    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $collect;


    /**
     * @var array
     */
    private $options;

    /**
     * @var name
     */
    private $appname;


    /**
     * @var RouteCollection
     */
    private $handled;

    /**
     * Route constructor.
     * @param Request $request
     * @param ContainerInterface $container
     * @param Config $config
     * @param array $options
     */
    public function __construct(
        Request $request,
        ContainerInterface $container,
        Config $config,
        array $options = []
    )
    {

        $this->request = $request;
        $this->container = $container;
        $this->config = $config;
        $this->options = $options;
        $this->appname = $config->get('app.name');
    }


    /**
     * @param array $methods
     * @param string $uri
     * @param arrray $options
     * @return $this
     */
    public function match($methods, $uri, $options)
    {
        $uri = $this->prepareUri($uri);

        if (!is_array($methods)) {
            $methods = [$methods];
        }

        $dispatchedData = $this->dispatchOptions($options, $uri);

        $route = new RouteDispatcher(
            '', array('options' => $dispatchedData)
        );

        $uri = isset($this->options['prefix']) ? $this->options['prefix'] . $uri : $uri;

        $options['methods'] = $methods;
        $route = (new RouteHandler($route, $options, $this->appname, $uri))
            ->handle()
            ->setMethods($methods);


        return $this->collect[] = $route;

    }


    /**
     * @param string $uri
     * @return string
     */
    private function prepareUri($uri)
    {
        $firstLetter = $uri[0];

        if ($firstLetter !== '/') {
            $uri = '/' . $uri;
        }

        return $uri;
    }

    /**
     * @param array $group
     * @param \Closure $callback
     * @return Routing
     */
    public function group($group, \Closure $callback)
    {
        $routing = new static(
            $this->request,
            $this->container,
            $this->config,
            $group,
            $this->appname
        );

        $this->container->add(Routing::class, $routing);

        // lets call the clasure
        $callback($routing);

        // return the orijinal content
        $this->container->add(Routing::class, $this);

        return $this->collect[] = $routing;
    }

    /**
     * defines a get route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function get($uri, $options)
    {
        return $this->match(['GET'], $uri, $options);
    }

    /**
     * defines a post route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function post($uri, $options)
    {
        return $this->match(['POST'], $uri, $options);
    }

    /**
     * defines a put route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function put($uri, $options)
    {
        return $this->match(['PUT'], $uri, $options);
    }

    /**
     * defines a delete route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function delete($uri, $options)
    {
        return $this->match(['DELETE'], $uri, $options);
    }

    /**
     * defines a head route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function head($uri, $options)
    {
        return $this->match(['HEAD'], $uri, $options);
    }

    /**
     * defines a patch route
     *
     * @param string $uri
     * @param array $options
     * @return RouteDispatcher
     */
    public function patch($uri, $options)
    {
        return $this->match(['PATCH'], $uri, $options);
    }


    /**
     * @param array|string $options
     * @param string $uri
     * @throws NotFoundException
     * @return DispatcherDataProvider
     */
    private function dispatchOptions(&$options, $uri = '')
    {
        if (is_string($options)) {
            $options = $this->getControllerAndMethodFromString($options);
        } elseif (is_array($options)) {
            $options = $this->parseControllerFromAction($options, $uri);
        }


        $namespace = isset($this->options['working']) ? $this->options['working'] :
            $this->config->get('http.route.namespace', 'App\Controllers');

        if (isset($options['namespace'])) {
            $namespace .= '\\' . $options['namespace'];
        }

        return new DispatcherDataProvider($namespace, $options['controller'], $options['method']);
    }

    /**
     * @param array $options
     * @param string $route
     * @return array
     * @throws NotFoundException
     */
    private function parseControllerFromAction($options, $route)
    {
        if (!isset($options['action'])) {
            throw new NotFoundException(sprintf('Your action couldnot find in %s route', $route));
        }

        $action = $options['action'];

        $options = array_merge($options, $this->getControllerAndMethodFromString($action));

        // we dont need that action any more, we will delete it.
        unset($options['action']);

        return $options;
    }

    /**
     * @param string $options
     * @return array
     */
    private function getControllerAndMethodFromString($options)
    {
        if (false === strpos($options, '::')) {
            $options = $options . '::' . $this->config->get('http.route.method');
        }

        list($controller, $method) = explode('::', $options);

        return array('controller' => $controller, 'method' => $method);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return Routing
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }


    /**
     * @return RouteCollection
     */
    public function handle()
    {
        // if we solved collections before we will return already resolved ones
        if (!empty($this->handled)) {
            return $this->handled;
        }

        $collections = $this->collect;


        $collection = $this->container->resolve(RouteCollection::class);

        foreach ($collections as $item) {
            // if item is a group of collections we will resolve it
            if ($item instanceof Routing) {
                $collection->addCollection(
                    $group = $this->handleGroupCollection($item->handle(), $item->getOptions())
                );

                continue;
            }

            // if given collection is already a defined route we don't need to anything do it.
            $collection->add($item->getName(), $item);
        }


        // we solved collection we dont need them anymore
        $this->collect = [];


        return $this->handled = $collection;
    }

    /**
     * @param RouteCollection $collection
     * @param array $options
     * @return RouteCollection
     */
    private function handleGroupCollection(RouteCollection $collection, array $options)
    {
        return (new RouteGroupHandler($collection, $options))->handle();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Routing
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}
