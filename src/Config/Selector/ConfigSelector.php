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
     * @type string
     */
    private $fileName;

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

        if(count($this->selectorParts) > 1) {
            $this->fileName = $this->selectorParts[0];
            $this->chunkFilename();
        }
    }

    /**
     * Returns the corresponding file name
     *
     * @return string
     */
    public function getFilename() {
        return $this->fileName;
    }

    /**
     * Returns the corresponding file name with extension and beginning slash
     *
     * @return string
     */
    public function getFilenameForRequire() {
        $name = DIRECTORY_SEPARATOR . $this->fileName . ".php";
        return $name;
    }

    /**
     * If we get a filename from selector, chunk out the first element of the selector array
     *
     * @return void
     */
    private function chunkFilename() {
        $this->selectorParts = array_splice($this->selectorParts, 1);
    }

    /**
     * Return the array of selector elements
     *
     * @return array
     */
    public function getSelectorArray() {
        return $this->selectorParts;
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
