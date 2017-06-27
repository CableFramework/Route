<?php

namespace Cable\Routing\Providers;


use Cable\Annotation\Annotation;
use Cable\Container\ServiceProvider;
use Cable\Routing\Annotations\Group;
use Cable\Routing\Annotations\Route;

class AnnotationServiceProvider extends ServiceProvider
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
        $this->getContainer()->resolve(Annotation::class)
            ->addCommand(new Route())
            ->addCommand(new Group());

        /*  $this->getContainer()
             ->singleton(Annotation::class, function (){
                 return $this->getContainer()->get(Annotation::class)
                     ->addCommand(new Route())
                     ->addCommand(new Group());
             }); */
    }
}