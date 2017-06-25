<?php

namespace Cable\Routing\Matcher;


trait RegexAwareTrait
{

    /**
     * @var string
     */
    private $identifier = ':';


    /**
     * @param $string
     * @return bool
     */
    public function hasRegexCommand($string){
        return strpos($string, $this->identifier) !== false;
    }
}