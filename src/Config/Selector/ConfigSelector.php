<?php namespace buildr\Config\Selector;

/**
 * BuildR - PHP based continuous integration server
 *
 * Helper class to process configuration selectors
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config\Selector
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ConfigSelector {

    /**
     * Selector separator (With . its a dotNotation selector)
     */
    const SELECTOR_SEPARATOR = ".";

    /**
     * @type string The original input string
     */
    private $selectorString;

    /**
     * @type array Holds the array, after we split down the string
     */
    private $selectorParts;

    /**
     * Constructor
     *
     * @param string $selectorString
     */
    public function __construct($selectorString) {
        $this->selectorString = $selectorString;
        $this->process();
    }

    /**
     * Initial processing of the given selector
     *
     * @throws \InvalidArgumentException
     */
    private function process() {
        $this->selectorParts = explode(self::SELECTOR_SEPARATOR, $this->selectorString);

        if((!is_array($this->selectorParts)) && (count($this->selectorParts) < 2)) {
            throw new \InvalidArgumentException("Tha selector need to be at least 2 parts!");
        }
    }

    /**
     * Return the file name without extension, basically its the first part of the selector
     *
     * @return string
     */
    public function getFileName() {
        return $this->selectorParts[0];
    }

    /**
     * Return tha file name, properly formatted
     *
     * @return string
     */
    public function getFilenameForRequire() {
        return DIRECTORY_SEPARATOR . $this->selectorParts[0] . '.php';
    }

    /**
     * Return the array of selector elements
     *
     * @return array
     */
    public function getSelectorArray() {
        $selectorArray = array_splice($this->selectorParts, 1);
        return $selectorArray;
    }

    /**
     * Returns the original selector string
     *
     * @return string
     */
    public function getOriginalSelector() {
        return $this->selectorString;
    }
}
