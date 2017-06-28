<?php

namespace Cable\Routing\Interfaces;


interface RequestInterface
{

    /**
     * returns full uri
     * @example http://localhost/path
     *
     * @return string
     */
    public function getUri();

    /**
     * returns requested path
     * @example /path
     *
     * @return mixed
     */
    public function getPath();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getScheme();

    /**
     * @return string
     */
    public function getHost();
}
