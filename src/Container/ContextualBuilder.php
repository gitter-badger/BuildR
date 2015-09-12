<?php namespace buildr\Container;

use buildr\Container\ContainerInterface;

/**
 * Helper class that gives an easy to read syntax
 * to create a contextual bindings in the container
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ContextualBuilder {

    /**
     * @type \buildr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @type string
     */
    protected $concrete;

    /**
     * @type string
     */
    protected $needs;

    /**
     * Constructor
     *
     * @param \buildr\Container\ContainerInterface $container
     * @param string $concrete
     */
    public function __construct(ContainerInterface $container, $concrete) {
        $this->container = $container;
        $this->concrete = $concrete;
    }

    /**
     * Set which abstract needs to give implementation
     *
     * @param $abstract
     *
     * @return \buildr\Container\ContextualBuilder
     */
    public function needs($abstract) {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Sets the given implementation
     *
     * @param string $implementation
     */
    public function give($implementation) {
        $this->container->contextual($this->concrete, $this->needs, $implementation);
    }

}
