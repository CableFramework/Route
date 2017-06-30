<?php

namespace Cable\Routing\Loader;


use Cable\Routing\Exceptions\LoaderException;
use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\LoaderInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlLoader implements LoaderInterface
{
    /**
     * @var string
     */
    private $yaml;


    /**
     *
     *
     * YamlLoader constructor.
     * @param string $content yaml content
     */
    public function __construct($content)
    {
        $this->yaml = $content;
    }

    /**
     * returns all loaded routes
     *
     * @throws LoaderException
     * @return RouteCollection
     */
    public function load()
    {
        try{
            $routes = Yaml::parse($this->yaml);

            if ( !isset($routes['routes'])) {
                throw new LoaderException('routes key not exists in yaml file, please check');
            }

            return (new ArrayLoader($routes['routes']))->load();
        }catch (ParseException $exception){
            throw new LoaderException(
                sprintf('Yaml can not loaded, error message: %s', $exception->getMessage())
            );
        }
    }
}