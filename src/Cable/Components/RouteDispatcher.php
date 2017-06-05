<?php
/**
 * Created by PhpStorm.
 * User: My
 * Date: 06/04/2017
 * Time: 09:47
 */

namespace Cable\Routing;


use Symfony\Component\Routing\Route;

class RouteDispatcher extends Route
{

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return RouteDispatcher
     */
    public function name($name)
    {
        return $this->setName($name);
    }
    /**
     * @param string $name
     * @return RouteDispatcher
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @param string $regex
     * @return $this
     */
    public function regex( $regex)
    {
        $this->addRequirements(array(
            $this->getName() => $regex
        ));

        return $this;
    }
}
