<?php

namespace Cable\Routing;


class RegexPrepare
{
    /**
     * @var Route
     */
    private $route;


    /**
     * @var array
     */
    private $parameters = [];

    /**
     * RegexPrepare constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function prepare()
    {
        $scheme = $this->prepareSchemeRegex();
        $host = $this->prepareHostRegex();
        $path = $this->preparePathRegex();
        $port = '.*?';

        return sprintf('#%s://%s%s%s#si', $scheme, $host, $port, $path);
    }


    /**
     * @return mixed|string
     */
    public function preparePathRegex()
    {
        $path = $this->route->getUri();

        if (strpos($path, ':') === false) {
            return $path;
        }


        if ($prepared =
            preg_replace_callback(
                '#:(?<command>[A-z0-0?]+)#',
                array($this, 'replaceCommandParameter'),
                $path
            )
        ) {
            return str_replace('.', '\.', $prepared);
        }

    }


    /**
     * @return string
     */
    public function prepareHostRegex()
    {
        $host = $this->route->getHost();

        if (strpos($host, ':') === false) {
            return $host;
        }


        if ($prepared =
            preg_replace_callback(
                '#:(?<command>[A-z0-0]+)#',
                array($this, 'replaceCommandParameter'),
                $host
            )
        ) {
            return str_replace('.', '\.', $prepared);
        }
    }

    /**
     * @param array $matched
     * @return string
     */
    public function replaceCommandParameter(array $matched)
    {
        $req = $this->route->getRequirements();

        $command = $matched['command'];

        if ( ! isset($req[$command])) {
            $selected = Routing::DEFAULT_REGEX;
        } else {
            $selected = $req[$command];
        }

        $optional = '';

        if (strpos($command, '?') !== false) {
            $optional = '?';
        }

        $this->parameters[] = $command;

        return sprintf('(?<%s>%s)%s', $command, $selected, $optional);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }


    /**
     * @return string
     */
    public function prepareSchemeRegex()
    {
        return sprintf('(?P<scheme_id>%s)', implode("|", $this->route->getScheme()));
    }
}