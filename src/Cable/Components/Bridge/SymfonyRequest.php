<?php

namespace Cable\Routing\Bridge;


use Cable\Routing\Interfaces\RequestInterface;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SymfonyRequest
 * @package Cable\Routing\Bridge
 */
class SymfonyRequest implements RequestInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * SymfonyRequest constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * returns full uri
     * @example http://localhost/path
     *
     * @return string
     */
    public function getUri()
    {
        return $this->request->getUri();
    }

    /**
     * returns requested path
     * @example /path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->request->getPathInfo();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->request->getMethod();
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->request->getScheme();
    }

    /**
     * @return string
     *
     * @throws SuspiciousOperationException
     */
    public function getHost()
    {
        return  $this->request->getHost();
    }
}