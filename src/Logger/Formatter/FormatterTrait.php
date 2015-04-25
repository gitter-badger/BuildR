<?php namespace buildr\Logger\Formatter;

/**
 * Formatter trait
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
