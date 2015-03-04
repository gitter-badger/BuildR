<?php namespace buildr\Config\Source;

use \buildr\Config\Source\ConfigSourceInterface;
use buildr\Startup\BuildrEnvironment;

/**
 * BuildR - PHP based continuous integration server
 *
 * Base class for configuration sources
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config\Source
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class ConfigSource implements ConfigSourceInterface {

    /**
     * Returns a short, unique name for this config source
     *
     * @return string
     */
    public function getName() {
        return self::SOURCE_NAME;
    }

    /**
     * Returns the current environment name as string
     *
     * @return null|string
     */
    public function getEnvironmentName() {
        return (string) BuildrEnvironment::getEnv();
    }
}
