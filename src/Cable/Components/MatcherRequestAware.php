<?php

namespace Cable\Routing;


use Cable\Routing\Interfaces\RequestInterface;

trait MatcherRequestAware
{

    /**
     * the instance of request
     *
     * @var RequestInterface
     */
    protected $request;


    /**
     * @return string
     */
    protected function getRequestUri(){
        return $this->request->getUri();
    }

}