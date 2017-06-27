<?php
namespace Cable\Routing\Annotations;

use Cable\Annotation\Command;

/**
 * Class Route
 * @package Cable\Routing\Annotations
 * @Annotation()
 * @Name("Group")
 */
class Group extends Command
{

    /**
     * @var string
     * @Annotation()
     *
     * @Required()
     */
    public $prefix;

    /**
     * @var array
     * @Annotation()
     *
     * @Default({"GET"})
     */
    public $methods;

    /**
     * @var string
     * @Annotation()
     *
     */
    public $host;

    /**
     * @var array
     * @Annotation()
     *
     */
    public $scheme;


    /**
     * @var array
     * @Annotation()
     *
     */
    public $defaults;

    /**
     * @var array
     * @Annotation()
     * @Default({})
     */
    public $requirements;
}
