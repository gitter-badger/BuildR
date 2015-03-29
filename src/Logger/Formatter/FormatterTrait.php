<?php namespace buildr\Logger\Formatter;

use buildr\Logger\Formatter\FormatterInterface;

trait FormatterTrait {

    /**
     * Currently active formatter, NULL if not specified
     * @type NULL
     */
    protected $formatter = NULL;

    /**
     * Set the formatter implementation
     *
     * @param \buildr\Logger\Formatter\FormatterInterface $formatter
     */
    public function setFormatter(FormatterInterface $formatter) {
        $this->formatter = $formatter;
    }

    /**
     * Return the current formatter, NULL if not specified
     *
     * @return \buildr\Logger\Formatter\FormatterInterface|NULL $formatter
     */
    public function getFormatter() {
        return $this->formatter;
    }
}