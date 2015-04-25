<?php namespace buildr\Logger\Formatter;

use buildr\Logger\Entry\LogEntryInterface;

/**
 * Formatter interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Formatter
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface FormatterInterface {

    /**
     * Format the given log entry
     *
     * @param \buildr\Logger\Entry\LogEntryInterface $entry
     *
     * @return mixed
     */
    public function format(LogEntryInterface $entry);

}
