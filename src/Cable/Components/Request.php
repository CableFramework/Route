<?php

namespace Cable\Routing;


use Cable\Routing\Interfaces\RequestInterface;
use Psr\Http\Message\RequestInterface as Psr7RequestInterface;

class Request implements RequestInterface
{

    /**
     * @var RequestInterface
     */
    private $psr7Request;

    /**
     * Request constructor.
     * @param Psr7RequestInterface $request
     */
    public function __construct(Psr7RequestInterface $request)
    {
        $this->psr7Request = $request;
    }

    /**
     * @return \Psr\Http\Message\UriInterface|string
     */
    public function getUri(){
        $uri = $this->psr7Request->getUri();

        $url = $uri->getScheme().'://'.$uri->getHost();

        $port = $uri->getPort();

        if (null !== $port) {
            $url .= ':'.$port;
        }

        if ($url[-1] !== '/') {
            $uri .= '/';
        }

        return $uri;
    }

    /**
     * returns requested path
     * @example /path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->psr7Request->getUri()->getPath();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->psr7Request->getMethod();
    }

    /**
     * returns scheme
     *
     * @example 'http'
     *
     * @return string
     */
    public function getScheme(){
        return $this->psr7Request->getUri()->getScheme();
    }

    /**
     * returns host string
     *
     * @return string
     */
    public function getHost()
    {
        return $this->psr7Request->getUri()->getHost();
    }
}
