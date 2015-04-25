<?php namespace buildr\Logger\Handler;

use buildr\Logger\Entry\LogEntryInterface;
use buildr\Logger\Formatter\FormatterInterface;
use buildr\Logger\LogFilterType;

/**
 * handler interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Handler
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface HandlerInterface {

    /**
     * Handle the LogEntry
     *
     * @param \buildr\Logger\Entry\LogEntryInterface $entry
     *
     * @return bool
     */
    public function handle(LogEntryInterface $entry);

    /**
     * Return the current formatter set to the current handler
     *
     * @return \buildr\Logger\Formatter\FormatterInterface
     */
    public function getFormatter();

    /**
     * Set the current entry formatter
     *
     * @param \buildr\Logger\Formatter\FormatterInterface $formatter
     *
     * @return void
     */
    public function setFormatter(FormatterInterface $formatter);

    /**
     * Set the level filter for the current handler
     *
     * @param $level
     * @param \buildr\Logger\LogFilterType $filterType
     *
     * @return mixed
     */
    public function setFilter($level, LogFilterType $filterType);

    /**
     * Remove all filtering from the handler. It means the handler can handle all levels
     *
     * @return void
     */
    public function removeFilter();

    /**
     * Determine if the handler handle the given level, with the current filtering settings
     *
     * @param int $level
     *
     * @return bool
     */
    public function isHandleThisLevel($level);

    /**
     * Return all handled levels
     *
     * @return array
     */
    public function getHandledLevels();

}
