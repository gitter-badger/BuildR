<?php namespace buildr\ServiceProvider;

/**
 * BuildR - PHP based continuous integration server
 *
 * Interface for ServiceProvider classes
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage ServiceProvider
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ServiceProviderInterface {

    /**
     * Returns an object that be registered to registry
     *
     * @return Object
     */
    public function register();

    /**
     * Returns the binding name in the registry
     *
     * @return string
     */
    public function getBindingName();
}