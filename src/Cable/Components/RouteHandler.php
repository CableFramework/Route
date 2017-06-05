<?php

namespace Cable\Routing;


class RouteHandler implements RouteHandlerInterface
{

    /**
     * @var RouteDispatcher
     */
    private $dispatcher;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $path;

    /**
     * RouteHandler constructor.
     * @param RouteDispatcher $dispatcher
     * @param array $options
     * @param $app
     */
    public function __construct(RouteDispatcher $dispatcher, array $options, $app, $path)
    {
        $this->dispatcher = $dispatcher;
        $this->options = $options;
        $this->appName = $app;
        $this->path = $path;
    }

    /**
     *
     */
    public function handle()
    {
        $options = $this->options;

        $this->resolvePath($this->path);

        if (isset($options['subdomain'])) {
            $this->resolveSubdomain($options['subdomain']);
        }

        if (isset($options['scheme'])) {
            $this->resolveSchemes($options['scheme']);
        }

        if (isset($options['name'])) {
            $this->dispatcher->setName($options['name']);
        } else {
            $this->dispatcher->setName(
                $this->resolveName($this->path, $options)
            );
        }


        return $this->dispatcher;
    }

    /**
     * resolves path
     *
     * @param $path
     *
     */
    private function resolvePath($path)
    {
        if ($path = preg_replace_callback('#{(.*?)}#si', array($this, 'callback'), $path)) {
            $this->dispatcher->setPath($path);
        }

        $this->dispatcher->setPath($path);
    }

    /**
     * @param $match
     * @return string
     */
    private function callback($match)
    {
        $match = $match[1];


        list($parameter, $definedRegex) = $this->parseMatchedUrl($match);

        if ( ! DefinedRegex::has($definedRegex)) {
            return '{'. $match. '}';
        }


        list($regex, $defaultValue) = DefinedRegex::get($definedRegex);


        if ($this->isOptional($parameter)) {
            $this->dispatcher->addDefaults(
                array(
                    $parameter => $defaultValue,
                )
            );
        }


        if ($regex !== '') {
            $this->dispatcher->addRequirements(
                array($parameter => $regex)
            );
        }


        return '{'. $parameter. '}';

    }
    /**
     * @param $parameter
     * @return bool
     */
    private function isOptional(&$parameter)
    {
        if (false !== strpos($parameter, '?')) {
            $parameter = str_replace('?', '', $parameter);

            return true;
        }

        return false;
    }

    /**
     * @param string $match
     * @return array
     */
    private function parseMatchedUrl($match)
    {
        if (false === strpos($match, ':')) {
            $match = $match.':'.'null';
        }

        return explode(':', $match);
    }

    /**
     * @param string $path
     * @param array $options
     * @return mixed
     */
    private function resolveName($path, array $options)
    {
        if (isset($options['name'])) {
            return $options['name'];
        }

        $resolved = $this->resolveNameByPath($path, $options['methods']);

        return $resolved === '' ? $this->appName.mt_rand(1, 9999) : $resolved;
    }

    /**
     * when given profile/name will return profile-name
     *
     * @param string $path
     * @param array $methods
     * @return mixed
     */
    private function resolveNameByPath($path, array $methods)
    {
        $replaced = str_replace('/', ' ', $path);

        $cleaned = trim($replaced);

        return str_replace(' ', '-', $cleaned).'-'.strtolower(implode('-', $methods));
    }

    /**
     * @param $scheme
     * @return $this
     */
    private function resolveSchemes($scheme)
    {
        $this->dispatcher->setSchemes($scheme);
    }

    /**
     * @param array $subdomain
     */
    private function resolveSubdomain( array $subdomain)
    {
        if (isset($subdomain['domain'])) {
            $this->dispatcher->setHost($subdomain['domain']);

            if (isset($subdomain['catch'])) {
                $catch = $subdomain['catch'];

                foreach ($catch as $key => $val) {
                    $this->dispatcher->addRequirements(
                        array(
                            $key => $val,
                        )
                    );
                }
            }
        }
    }
}
