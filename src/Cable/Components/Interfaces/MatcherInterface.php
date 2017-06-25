<?php

namespace Cable\Routing\Interfaces;

/**
 * Interface MatcherInterface
 * @package Cable\Routing\Interfaces
 */
interface MatcherInterface
{

    /**
     * @return mixed
     */
    public function match();
}