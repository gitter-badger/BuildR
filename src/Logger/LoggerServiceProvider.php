<?php namespace buildr\Logger;

use buildr\Logger\Attachment\MemoryUsageAttachment;
use buildr\Logger\Formatter\LineFormatter;
use buildr\Logger\Handler\StdOutHandler;
use buildr\Logger\Logger;
use buildr\ServiceProvider\ServiceProviderInterface;
use Psr\Log\LogLevel;

/**
 * BuildR - PHP based continuous integration server
 *
 * Service Provider for Logger
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class LoggerServiceProvider implements ServiceProviderInterface {

    /**
     * Returns an object that be registered to registry
     *
     * @return Object
     */
    public function register() {
        $logger = new Logger('buildrLogger');

        $stdOutHandler = new StdOutHandler();
        $stdOutHandler->setFormatter(new LineFormatter());

        $logger->pushHandler($stdOutHandler);
        $logger->pushAttachment(new MemoryUsageAttachment());

        return $logger;
    }


    /**
     * Returns the binding name in the registry
     *
     * @return string
     */
    public function getBindingName() {
        return "logger";
    }

}
