<?php namespace buildr\Config;

use \buildr\Config\Source\ConfigSourceInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * 
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ConfigInterface {

    /**
     * Get the configuration value from the main config source (Default: File)
     *
     * @param string $selector A dot-notated selector string
     * @param null|mixed $defaultValue
     * @return mixed
     */
    public function getFromMainSource($selector, $defaultValue = NULL);

    /**
     * Try to get configuration value from any configuration source. Sources
     * ordered by its priority.
     *
     * @param string $selector A dot-notated selector string
     * @param null $defaultValue
     * @return mixed
     */
    public function getFormAnySource($selector, $defaultValue = NULL);

    /**
     * Get a configuration value from a pre-defined source
     *
     * @param string $sourceName Use sources SOURCE_NAME constant to define
     * @param string $selector A dot-notated selector string
     * @param null $defaultValue
     * @return mixed
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getFromSource($sourceName, $selector, $defaultValue = NULL);

    /**
     * Push a new configuration source to the source stack
     *
     * @param \buildr\Config\Source\ConfigSourceInterface $source
     * @param int $priority
     * @throws \buildr\Config\Exception\ConfigurationException
     * @throws \InvalidArgumentException
     */
    public function addSource(ConfigSourceInterface $source, $priority);

    /**
     * Return a configuration source by priority
     *
     * @param int $priority
     * @return \buildr\Config\Source\ConfigSourceInterface
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getSourceByPriority($priority);

    /**
     * Return a configuration source by its name
     *
     * @param string $name
     * @return \buildr\Config\Source\ConfigSourceInterface
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getSourceByName($name);

    /**
     * Returns the main configuration file statically
     *
     * @return array
     */
    public static function getMainConfig();

    /**
     * Returns the registry binding list from the config
     *
     * @return array
     */
    public static function getProviderConfig();

    /**
     * Get config for environment detection. This is specific for initialization. Its not call the
     * initialize() method on this class. Its basically allow to me to use environmental base
     * configuration later on initialization
     *
     * @return array
     */
    public static function getEnvDetectionConfig();

}
