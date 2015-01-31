<?php namespace buildr\Filesystem;

use buildr\ServiceProvider\ServiceProviderInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Service provider for Filesystem class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Filesystem
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class FilesystemServiceProvider implements ServiceProviderInterface {

    /**
     * Returns an object that be registered to registry
     *
     * @return Object
     */
    public function register() {
        return new Filesystem();
    }

    /**
     * Returns the binding name in the registry
     *
     * @return string
     */
    public function getBindingName() {
        return 'filesystem';
    }

}
