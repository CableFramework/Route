<?php
namespace Cable\Routing\Interfaces;


use Cable\Routing\RouteCollection;

/**
 * Interface ExporterInterface
 * @package Cable\Routing\Interfaces
 */
interface ExporterInterface
{

    /**
     * export route collection
     *
     * @param RouteCollection $collection
     * @return mixed
     */
    public function export(RouteCollection $collection);
}
