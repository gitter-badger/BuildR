<?php namespace buildr\Logger\Entry;

use buildr\Utils\StringUtils;
use \DateTime;

/**
 * BuildR - PHP based continuous integration server
 *
 * Loge entry class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Entry
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class LogEntry implements LogEntryInterface {

    /**
     * @type string
     */
    private $message;

    /**
     * @type array
     */
    private $context = [];

    /**
     * @type int
     */
    private $level;

    /**
     * @type \DateTime
     */
    private $date;

    /**
     * @type array
     */
    private $attachments;

    /**
     * @type bool
     */
    private $isHandled = FALSE;

    /**
     * Constructor
     *
     * @param string $message
     * @param array $context
     * @param int $level
     * @param \DateTime $date
     * @param array $attachments
     */
    public function __construct($message, $context, $level, DateTime $date, $attachments = []) {
        $this->message = $message;
        $this->context = $context;
        $this->level = $level;
        $this->date = $date;
        $this->attachments = $attachments;
    }

    /**
     * Returns the level of the this entry
     *
     * @return string
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Get the attachments as array
     *
     * @return array
     */
    public function getAttachments() {
        return $this->attachments;
    }

    /**
     * Return the entry date as PHP \DateTime object
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Return the message, substituted wih context
     *
     * @return string
     */
    public function getMessage() {
        return StringUtils::substitution($this->message, $this->context);
    }

    /**
     * Return the rew message
     *
     * @return string
     */
    public function getRawMessage() {
        return $this->message;
    }

    /**
     * Return the handling state of this entry
     *
     * @return bool
     */
    public function isHandled() {
        return $this->isHandled;
    }

    /**
     * Mark this entry as handled. Its prevent other handlers to receive this message
     */
    public function setHandled() {
        $this->isHandled = TRUE;
    }

}