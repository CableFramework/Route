<?php

namespace Cable\Routing;


use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

class Generator implements GeneratorInterface
{

    private $generator;


    public function __construct(Routing $routing, RequestContext $context)
    {
        $this->generator = new UrlGenerator(
            $routing->handle(),
            $context
        );
    }


    /**
     * generate a url from given route name
     *
     * @param string $name
     * @param array $slugs
     *
     * @return string
     */
    public function generate($name, array $slugs = [])
    {
        return $this->generator->generate($name, $slugs);
    }
}