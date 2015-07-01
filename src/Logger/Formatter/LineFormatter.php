<?php namespace buildr\Logger\Formatter;

use buildr\Logger\Formatter\FormatterInterface;
use buildr\Logger\Entry\LogEntryInterface;

/**
 * Line formatter
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
class LineFormatter implements FormatterInterface {

    /**
     * Format the given log entry
     *
     * @param \buildr\Logger\Entry\LogEntryInterface $entry
     *
     * @return mixed
     */
    public function format(LogEntryInterface $entry) {
        $attachmentString = "";

        foreach ($entry->getAttachments() as $tag => $value) {
            $attachmentString .= "[" . $tag . " -> " . $value . "]";
        }

        return "[" . $entry->getDate()->format("Y-m-d H:i:s") . "][" . strtoupper($entry->getLevel()) . "] " .
                $entry->getMessage() . $attachmentString;
    }

}
