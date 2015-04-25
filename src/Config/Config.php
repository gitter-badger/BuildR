<?php namespace buildr\Config;

use buildr\Config\Exception\ConfigurationException;
use buildr\Config\Selector\ConfigSelector;
use buildr\Config\Source\ConfigSourceInterface;
use InvalidArgumentException;

/**
 * Configuration class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Config implements ConfigInterface {

    const DEFAULT_PRIORITY = 50;

    /**
     * @type \buildr\Config\Source\ConfigSourceInterface[]
     */
    private $sources = [];

    /**
     * Constructor
     *
     * @param \buildr\Config\Source\ConfigSourceInterface $source
     *
     * @codeCoverageIgnore
     */
    public function __construct(ConfigSourceInterface $source) {
        $this->sources[self::DEFAULT_PRIORITY] = $source;
    }

    /**
     * Get the configuration value from the main config source (Default: File)
     *
     * @param string $selector A dot-notated selector string
     * @param null|mixed $defaultValue
     *
     * @return mixed
     */
    public function getFromMainSource($selector, $defaultValue = NULL) {
        $source = $this->sources[self::DEFAULT_PRIORITY];
        $selector = new ConfigSelector($selector);

        $result = $source->get($selector, $defaultValue);

        return $result;
    }

    /**
     * Try to get configuration value from any configuration source. Sources
     * ordered by its priority.
     *
     * @param string $selector A dot-notated selector string
     * @param null $defaultValue
     *
     * @return mixed
     */
    public function getFormAnySource($selector, $defaultValue = NULL) {
        $selector = new ConfigSelector($selector);

        foreach ($this->sources as $source) {
            $result = $source->get($selector, $defaultValue);

            return $result;
        }

        return $defaultValue;
    }

    /**
     * Get a configuration value from a pre-defined source
     *
     * @param string $sourceName Use sources SOURCE_NAME constant to define
     * @param string $selector A dot-notated selector string
     * @param null $defaultValue
     *
     * @return mixed
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getFromSource($sourceName, $selector, $defaultValue = NULL) {
        try {
            $source = $this->getSourceByName($sourceName);
        } catch (ConfigurationException $e) {
            return $defaultValue;
        }

        $selector = new ConfigSelector($selector);

        $result = $source->get($selector, $defaultValue);

        return $result;
    }

    /**
     * Push a new configuration source to the source stack
     *
     * @param \buildr\Config\Source\ConfigSourceInterface $source
     * @param int $priority
     *
     * @throws \buildr\Config\Exception\ConfigurationException
     * @throws \InvalidArgumentException
     */
    public function addSource(ConfigSourceInterface $source, $priority) {
        if(!is_numeric($priority)) {
            throw new \InvalidArgumentException("The priority must be a number!");
        }

        $priority = (int) $priority;

        if(isset($this->sources[$priority])) {
            throw new ConfigurationException("The priority ({$priority}) is already taken!");
        }

        $this->sources[$priority] = $source;
        ksort($this->sources);
    }

    /**
     * Return a configuration source by priority
     *
     * @param int $priority
     *
     * @return \buildr\Config\Source\ConfigSourceInterface
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getSourceByPriority($priority) {
        if(!isset($this->sources[$priority])) {
            throw new ConfigurationException("No configuration source exist at priority " . $priority . "!");
        }

        return $this->sources[$priority];
    }

    /**
     * Return a configuration source by its name
     *
     * @param string $name
     *
     * @return \buildr\Config\Source\ConfigSourceInterface
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    public function getSourceByName($name) {
        foreach ($this->sources as $source) {
            if($source->getName() == $name) {
                return $source;
            }
        }

        throw new ConfigurationException("Not found any configuration source, registered with name: " . $name . "!");
    }

    /**
     * Returns the main configuration file statically
     *
     * @return array
     */
    public static final function getMainConfig() {
        $mainConfig = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');

        return require $mainConfig;
    }

    /**
     * Returns the registry binding list from the config
     *
     * @return array
     */
    public static final function getProviderConfig() {
        return self::getMainConfig()['serviceProviders'];
    }

    /**
     * Get config for environment detection. This is specific for initialization. Its not call the
     * initialize() method on this class. Its basically allow to me to use environmental base
     * configuration later on initialization
     *
     * @return array
     */
    public static final function getEnvDetectionConfig() {
        return self::getMainConfig()['startup'];
    }
}
