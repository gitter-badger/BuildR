<?php namespace buildr\Logger;

use buildr\Logger\Attachment\AttachmentInterface;
use buildr\Logger\Entry\LogEntry;
use buildr\Logger\Exception\InvalidTimeZoneException;
use buildr\Logger\Handler\HandlerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use \DateTime;
use \DateTimeZone;

/**
 * BuildR - PHP based continuous integration server
 *
 * PSR-3 compatible logger class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Logger extends AbstractLogger implements LoggerInterface {

    /**
     * @type string
     */
    private $name;

    /**
     * @type string
     */
    private $timeZone;

    /**
     * @type array
     */
    private $handlers = [];

    /**
     * @type array
     */
    private $attachments = [];
    /**
     * @type array
     */
    public static $levels = ['emergency' => 0, 'alert' => 1, 'critical' => 2, 'error' => 3, 'warning' => 4, 'notice' => 5, 'info' => 6, 'debug' => 7];

    /**
     * Constructor
     *
     * @param string $name
     * @param string $timeZone
     * @throws \buildr\Logger\Exception\InvalidTimeZoneException
     */
    public function __construct($name, $timeZone = "UTC") {
        $this->name = $name;

        try {
            $this->timeZone = new DateTimeZone($timeZone);
        } catch(\Exception $e) {
            throw new InvalidTimeZoneException("This TimeZone string (" . $timeZone . ") is no a valid time zone!");
        }
    }

    /**
     * Push a new handler to the stack
     *
     * @param \buildr\Logger\Handler\HandlerInterface $handler
     */
    public function pushHandler(HandlerInterface $handler) {
        array_unshift($this->handlers, $handler);
    }

    /**
     * Push a new handler to the stack
     *
     * @param \buildr\Logger\Attachment\AttachmentInterface $attachments
     */
    public function pushAttachment(AttachmentInterface $attachments) {
        array_unshift($this->attachments, $attachments);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return null
     */
    public function log($level, $message, array $context = []) {
        $date = new DateTime("now", $this->timeZone);
        $attachments = $this->getAttachmentArray();
        $logEntry = new LogEntry($message, $context, $level, $date, $attachments);

        /**
         * @var \buildr\Logger\Handler\HandlerInterface $handler
         */
        foreach($this->handlers as $handler) {
            $result = $handler->handle($logEntry);

            //If the handling is success and the entry is currently in unhandled state, mark it handled
            if(($result === TRUE) && ($logEntry->isHandled() === FALSE)) {
                $logEntry->setHandled();
            }
        }
    }

    /**
     * Process attachment to acceptable format for logEntry
     *
     * @return array
     */
    private function getAttachmentArray() {
        $attachments = [];

        /**
         * @var \buildr\Logger\Attachment\AttachmentInterface $attachment
         */
        foreach($this->attachments as $attachment) {
            $attachments[$attachment->getIdentifier()] = $attachment->getValue();
        }

        return $attachments;
    }


}
