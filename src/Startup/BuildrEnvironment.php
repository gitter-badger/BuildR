<?php namespace buildr\Startup;
use buildr\Config\Config;
use buildr\Startup\Environment\Detector\EnvironmentException;
use buildr\Startup\Environment\EnvironmentDetector;

/**
 * BuildR - PHP based continuous integration server
 *
 * Environment handler
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class BuildrEnvironment {

    /**
     * Production environment constant
     */
    const E_PROD = "production";

    /**
     * Development environment constant
     */
    const E_DEV = "development";

    /**
     * Default environment on console run
     */
    const E_CONSOLE = "console-default";

    /**
     * Environment for unit tests
     */
    const E_TESTING = "testing";

    /**
     * @type string
     */
    private static $currentEnvironment;

    /**
     * @type bool
     */
    private static $isInitialized = FALSE;

    /**
     * Returns the current environment of the application
     *
     * @return null|string
     */
    public static final function getEnv() {
        if(self::$isInitialized === FALSE) {
            return NULL;
        }

        return self::$currentEnvironment;
    }

    /**
     * Run the environment detection. If the callback is a Closuer will run teh closure
     * and returns the result, in other case get the detector class from the config
     * and use the detect() method as the closer
     *
     * @param \Closure|null $callback
     * @throws \buildr\Startup\Environment\Detector\EnvironmentException
     */
    public static final function detectEnvironment($callback = null) {
        $consoleArgs = (isset($_SERVER['argv'])) ? $_SERVER['argv'] : NULL;

        if(!($callback instanceof \Closure)) {
            $callback = self::getDetectorClosure();
        }

        self::$currentEnvironment = (new EnvironmentDetector())->detect($callback, $consoleArgs);
        self::$isInitialized = TRUE;
    }

    /**
     * Set environment to unit testing mode
     */
    public static final function isRunningUnitTests() {
        self::$isInitialized = TRUE;
        self::$currentEnvironment = self::E_TESTING;
    }

    /**
     * Returns the dynamically created closure from a Datector class detect() method
     *
     * @return callable
     * @throws \buildr\Startup\Environment\Detector\EnvironmentException
     */
    private static function getDetectorClosure() {
        $envConfig = Config::getEnvDetectionConfig();
        $detectorClass = $envConfig['detector'];
        $detectorReflector = new \ReflectionClass($detectorClass);

        if(!$detectorReflector->implementsInterface('buildr\Startup\Environment\Detector\DetectorInterface')) {
            throw new EnvironmentException("The class ({$detectorClass}) must be implements the DetectorInterface!");
        }

        $methodReflector = $detectorReflector->getMethod("detect");
        return $methodReflector->getClosure($detectorReflector->newInstance());
    }

}
