<?php

namespace Cable\Routing;


use Symfony\Component\HttpFoundation\Request;

trait MatcherRequestAware
{

    /**
     * the instance of request
     *
     * @var Request
     */
    protected $request;


    /**
     * @return string
     */
    protected function getRequestUri(){
        $uri = $this->request->getUri();


        if ($uri[-1] !== '/') {
            $uri .= '/';
        }

        return $uri;
    }

}