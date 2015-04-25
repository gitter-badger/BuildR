<?php namespace buildr\Config\Source;

use buildr\Config\Exception\ConfigurationException;
use buildr\Config\Exception\InvalidConfigKeyException;
use buildr\Config\Selector\ConfigSelector;
use buildr\Filesystem\Facade\Filesystem;

/**
 * PHP Array configuration source
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Confog\Source
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PHPConfigSource extends CachedConfigSource {

    const SOURCE_NAME = "CONFIG_PHP_SOURCE";

    /**
     * @type string
     */
    protected $sourceFolder;

    /**
     * @type string
     */
    protected $environmentalSourceFolder;

    /**
     * Constructor
     */
    public function __construct() {
        $this->detectPaths();
    }

    /**
     * Get a configuration value by selector
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function get(ConfigSelector $selector, $defaultValue = NULL) {
        $cacheKey = $this->getCacheKeyForSelector($selector);
        $cacheEntry = $this->getCache()->get($cacheKey);

        if($cacheEntry->isHit()) {
            return $cacheEntry->getValue();
        }

        try {
            $value = $this->getBySelector($selector);
            $this->getCache()->set($cacheKey, $value);

            return $value;
        } catch (InvalidConfigKeyException $e) {
            return $defaultValue;
        } catch (ConfigurationException $e) {
            return $defaultValue;
        }
    }

    /**
     * Process the selector, get files content, merge it, and iterate over the selector, to give
     * the real config value
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     *
     * @return array
     * @throws \buildr\Config\Exception\ConfigurationException
     * @throws \buildr\Config\Exception\InvalidConfigKeyException
     */
    protected function getBySelector(ConfigSelector $selector) {
        $fileName = $selector->getFilenameForRequire();

        //Try to get environmental file content
        $environmentalContent = [];
        if(($envResult = $this->getEnvContent($fileName)) !== NULL) {
            $environmentalContent = $envResult;
        }

        //main config file content
        $mainContent = $this->getMainContent($fileName);

        //And the merged, final content
        $fullContent = array_merge($mainContent, $environmentalContent);

        $selectorTmp = $fullContent;

        foreach ($selector->getSelectorArray() as $selector) {
            if(isset($selectorTmp[$selector])) {
                $selectorTmp = $selectorTmp[$selector];
                continue;
            }

            throw new InvalidConfigKeyException("The following part of the config not found: {$selector}!");
        }

        return $selectorTmp;
    }

    /**
     * Returns the environmental based config file content, if is exist
     *
     * @param $filename
     *
     * @return mixed|null
     */
    protected function getEnvContent($filename) {
        $environmentalFile = $this->environmentalSourceFolder . $filename;

        if(file_exists($environmentalFile)) {
            return require $environmentalFile;
        }

        return NULL;
    }

    /**
     * Return the main config file content
     *
     * @param $filename
     *
     * @return mixed
     * @throws \buildr\Config\Exception\ConfigurationException
     */
    protected function getMainContent($filename) {
        $normalFile = $this->sourceFolder . $filename;

        if(!file_exists($normalFile)) {
            throw new ConfigurationException("The following configuration file Not found: " . $filename . "!");
        }

        return require $normalFile;
    }

    /**
     * Detect configuration source paths
     *
     * @return void
     */
    protected function detectPaths() {
        $this->sourceFolder = Filesystem::makeAbsolute('/config') . DIRECTORY_SEPARATOR;
        $this->environmentalSourceFolder = Filesystem::makeAbsolute($this->sourceFolder . '/' . $this->getEnvironmentName()) . DIRECTORY_SEPARATOR;
    }
}
