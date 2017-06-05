<?php

namespace Cable\Routing;

/**
 * Interface GeneratorInterface
 * @package Cable\Routing
 */
interface GeneratorInterface
{

    /**
     * generate a url from given route name
     *
     * @param string $name
     * @param array $slugs
     *
     * @return string
     */
    public function generate($name,array $slugs = []);
}
