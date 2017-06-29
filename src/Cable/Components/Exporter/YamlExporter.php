<?php

namespace Cable\Routing\Exporter;


use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\ExporterInterface;
use Symfony\Component\Yaml\Yaml;

class YamlExporter implements ExporterInterface
{

    /**
     * export route collection
     *
     * @param RouteCollection $collection
     * @return mixed
     */
    public function export(RouteCollection $collection)
    {
         $array = (new ArrayExporter())->export($collection);

         return Yaml::dump(array('routes' => $array));
    }
}