<?php namespace buildr\Startup\Initializer;

use buildr\Loader\classLoader;

/**
 * Initializer interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Initializer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface InitializerInterface {

    /**
     * Run the startup initialization process
     *
     * @param string $basePath
     * @param \buildr\Loader\classLoader $autoloader
     *
     * @return bool
     */
    public function initialize($basePath, classLoader $autoloader);

}
