<?php

namespace Cable\Routing;


use Cable\Container\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider extends ServiceProvider
{

    /**
     * register new providers or something
     *
     * @return mixed
     */
    public function boot()
    {

    }

    /**
     * register the content
     *
     * @return mixed
     */
    public function register()
    {
        $this->getContainer()
            ->singleton(
                Request::class,
                function () {
                    return Request::createFromGlobals();
                }
            );
    }
}