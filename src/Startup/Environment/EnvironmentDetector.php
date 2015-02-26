<?php namespace buildr\Startup\Environment;

use buildr\Startup\BuildrEnvironment;
use buildr\Utils\String\StringUtils;

/**
 * BuildR - PHP based continuous integration server
 *
 * Environment detector class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Environment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class EnvironmentDetector {

    /**
     * Initial detection method. If the console arguments ar present try to detect environment from it, if it
     * fails return the default console environment. If the console arguments not present invoke the given
     * closure to get the web environment
     *
     * @param callable $callback
     * @param null $consoleArgs
     * @return mixed|string
     */
    public function detect(\Closure $callback, $consoleArgs = NULL) {
        if($consoleArgs != NULL) {
            $consoleEnv = $this->detectEnvByConsoleArgs($consoleArgs);

            if($consoleEnv == NULL) {
                return BuildrEnvironment::E_CONSOLE;
            }

            return $consoleEnv;
        }

        return $this->detectByCallback($callback);
    }

    /**
     * Runs the closure and returns its result
     *
     * @param callable $callback
     * @return mixed
     */
    private function detectByCallback(\Closure $callback) {
        return call_user_func($callback);
    }

    /**
     * Get the environment from the proper console argument
     *
     * @param $consoleArgs
     * @return string|null
     */
    private function detectEnvByConsoleArgs($consoleArgs) {
        foreach($consoleArgs as $consoleArg) {
            if(StringUtils::startWith($consoleArg, '--env=')) {
                return StringUtils::trimFromBeginning($consoleArg, '--env=');
            }
        }

        return NULL;
    }
}
