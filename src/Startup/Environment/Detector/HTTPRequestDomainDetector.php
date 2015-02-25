<?php namespace buildr\Startup\Environment\Detector;

use buildr\Config\Config;
use buildr\Startup\Environment\Detector\DetectorInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Environment detector by HTTP requests domain
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Environment\Detector
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class HTTPRequestDomainDetector implements DetectorInterface {

    /**
     * Returns the detected environment as string
     *
     * @return string
     */
    public function detect() {
        $envDetectionConfig = Config::getEnvDetectionConfig();
        $currentDomain = $_SERVER['HTTP_HOST'];

        foreach($envDetectionConfig['domains'] as $env => $domains) {
            foreach($domains as $domain) {
                if($domain == $currentDomain) {
                    return $env;
                }
            }
        }
    }
}