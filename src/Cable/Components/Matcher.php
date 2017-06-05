<?php

namespace Cable\Routing;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class Matcher implements MatcherInterface
{

    /**
     * @var UrlMatcher
     */
    private $matcher;

    /**
     * @var Request
     */
    private $request;

    /**
     * Matcher constructor.
     * @param Routing $routing
     * @param RequestContext $context
     */
    public function __construct(Routing $routing, RequestContext $context)
    {
        $this->request = $routing->getRequest();

        $this->matcher = new UrlMatcher(
            $routing->handle(),
            $context
        );

    }


    /**
     * match the given request
     *
     * @return array
     */
    public function match()
    {

        return $this->matcher->matchRequest(
            $this->request
        );
    }
}
