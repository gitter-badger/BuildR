<?php namespace buildr\Loader;

/**
 * BuildR - PHP based continuous integration server
 *
 * Interface for class loader implementations
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface classLoaderInterface {

    /**
     * Called on loader registration. Its allow to listen to registration event
     *
     * @return void
     */
    public function register();

    /**
     * Load the specified class
     *
     * @param string $className
     * @return bool
     */
    public function load($className);

    /**
     * Return the priority of this loader. It's not a constant!
     *
     * @return int
     */
    public function getPriority();

    /**
     * Set the priority of this autolaoder. Its called on registration when the pre-specified priority
     * is already reserved by another loader
     *
     * @param int $priority
     * @return void
     */
    public function setPriority($priority);

    /**
     * The loader unique name
     *
     * @return string
     */
    public function getName();
}