<?php
namespace Cable\Routing\Exporter;


use Cable\Routing\RouteCollection;
use Cable\Routing\Interfaces\ExporterInterface;

/**
 * Class ArrayExporter
 * @package Cable\Routing\Exporter
 */
class ArrayExporter implements ExporterInterface
{


    /**
     * export route collection
     *
     * @param RouteCollection $collection
     * @return mixed
     */
    public function export(RouteCollection $collection)
    {
         $routes = [];
         $collectionRoutes = $collection->getRoutes();

        if (empty($collectionRoutes)) {
            return $routes;
        }

         foreach ($collectionRoutes as $collectionRoute){
            $route =  [
                'path' => $collectionRoute->getUri(),
                'scheme' => $collectionRoute->getScheme(),
                'methods' => $collectionRoute->getMethods(),
                'name' => $collectionRoute->getName(),
            ];

             if ( !empty($collectionRoute->getHost())) {
                 $route['host'] = $collectionRoute->getHost();
              }

             if ( !empty($collectionRoute->getDefaults())) {
                 $route['defaults'] = $collectionRoute->getDefaults();
             }

             if ( !empty($collectionRoute->getRequirements())) {
                 $route['requirements'] = $collectionRoute->getRequirements();
             }

             $routes[] = $route;
         }

         return $routes;
    }
}