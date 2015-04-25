<?php namespace buildr\Logger\Handler;

use buildr\Logger\Entry\LogEntryInterface;
use buildr\Logger\Formatter\FormatterTrait;

/**
 * Write all log to the PHP STDOUT
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
class StdOutHandler implements HandlerInterface {

    use FilterableHandlerTrait;
    use FormatterTrait;

    /**
     * Handle the LogEntry
     *
     * @param \buildr\Logger\Entry\LogEntryInterface $entry
     *
     * @return bool
     */
    public function handle(LogEntryInterface $entry) {
        if($this->isHandleThisLevel($entry->getLevel())) {

            $message = $entry->getMessage();
            if(($formatter = $this->getFormatter()) !== NULL) {
                $message = $formatter->format($entry);
            }

            $this->writeToStdOut($message);

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Write message to php STDOUT
     *
     * @param string $message
     */
    private function writeToStdOut($message) {
        $out = fopen('php://output', 'w');
        fwrite($out, $message);
    }

}
