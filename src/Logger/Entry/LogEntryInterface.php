<?php namespace buildr\Logger\Entry;

/**
 * Interface for LogEntry
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Entry
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface LogEntryInterface {

    /**
     * Returns the level of the this entry
     *
     * @return string
     */
    public function getLevel();

    /**
     * Get the attachments as array
     *
     * @return array
     */
    public function getAttachments();

    /**
     * Return the entry date as PHP \DateTime object
     *
     * @return \DateTime
     */
    public function getDate();

    /**
     * Return the message, substituted wih context
     *
     * @return string
     */
    public function getMessage();

    /**
     * Return the rew message
     *
     * @return string
     */
    public function getRawMessage();

    /**
     * Return the handling state of this entry
     *
     * @return bool
     */
    public function isHandled();

    /**
     * Mark this entry as handled. Its prevent other handlers to receive this message
     */
    public function setHandled();

}
