<?php

namespace Cable\Routing;


use Cable\Config\Config;
use Cable\Container\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * register new providers or something
     *
     * @return mixed
     */
    public function boot(){}

    /**
     * register the content
     *
     * @return mixed
     */
    public function register()
    {
        $app = $this->getContainer();

        $app->singleton(
            RequestContext::class,
            function () use ($app) {
                return (new RequestContext())
                    ->fromRequest($app->resolve(Request::class));
            }
        );

        // default regex,
        DefinedRegex::add('null', '', null);

        $defined = $app->resolve(Config::class)->get('http.route.defined', [
            'int' => array('^[0-9]*$', 0),
            'alpha' => array('^[a-zA-Z]*$', ''),
            'anum' => array('^[a-zA-Z0-9]*$', '')
        ]);

        // add defined regex to use
        foreach ($defined as $name => list($regex, $default))
        {
            DefinedRegex::add($name, $regex, $default);
        }


        // save routing
        $app->singleton(Routing::class, Routing::class);

        // add the matchers
        $app->singleton(Matcher::class, Matcher::class);
        $app->singleton(Generator::class, Generator::class);


        $app->alias(RoutingInterface::class, Routing::class);

    }
}
