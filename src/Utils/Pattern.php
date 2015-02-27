<?php namespace buildr\Utils;

/**
 * BuildR - PHP based continuous integration server
 *
 * Basic pattern matching class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\String
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Pattern {

    /**
     * @var string
     */
    private $originalPattern = NULL;

    /**
     * @var null|string
     */
    private $regex = NULL;

    /**
     * Constructor
     *
     * @param $pattern
     */
    public function __construct($pattern) {
        $this->originalPattern = $pattern;
    }

    /**
     * Returns the original provided pattern
     *
     * @return string
     */
    public function getOriginal() {
        return $this->originalPattern;
    }

    /**
     * Format the provided pattern to regex and returns it
     *
     * @return null|string
     */
    public function getRegex() {
        if($this->regex === NULL) {
            $this->process();
        }

        return $this->regex;
    }

    /**
     * Process the given pattern to regex
     */
    private function process() {
        $charArray = str_split($this->originalPattern);
        $regex = "/";

        foreach($charArray as $key => $char) {
            switch($char) {
                case '*':
                    $regex .= ".*";
                    break;
                case '.':
                    $regex .= ".";
                    break;
                default:
                    $regex .= $char;
                    break;
            }
        }

        $regex .= "$/im";

        $this->regex = $regex;
    }

}
