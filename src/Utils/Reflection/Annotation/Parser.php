<?php namespace buildr\Utils\Reflection\Annotation;

/**
 * BuildR - PHP based continuous integration server
 *
 * Annotation parser
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\Reflection\Annotation
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Parser {

    /**
     * @type string
     */
    private $rawBlock;

    /**
     * @type array
     */
    private $parameters = [];

    const END_PATTERN = "[ ]*(?:@|\r\n|\n)";
    const KEY_PATTERN = "[A-z0-9\_\-]+";

    /**
     * Constructor
     *
     * @param string $rawBlock
     */
    public function __construct($rawBlock) {
        $this->rawBlock = $rawBlock;
        $this->parseBlock($this->getRawBlock());
    }

    /**
     * Return the parsed result from the docblock
     *
     * @return array
     */
    public function getResult() {
        return $this->parameters;
    }

    /**
     * Returns the raw docblock
     *
     * @return string
     */
    public function getRawBlock() {
        return $this->rawBlock;
    }

    /**
     * Parse a raw doc block to array
     *
     * @param string $rawBlock
     */
    private function parseBlock($rawBlock) {
        $pattern = "/@(?=(.*)" . self::END_PATTERN . ")/U";
        preg_match_all($pattern, $rawBlock, $matches);

        foreach($matches[1] as $rawParameter)  {
            if(preg_match("/^(" . self::KEY_PATTERN . ") (.*)$/", $rawParameter, $match))  {
                if(isset($this->parameters[$match[1]]))  {
                    $this->parameters[$match[1]] = array_merge((array)$this->parameters[$match[1]], (array)$match[2]);
                } else {
                    $this->parameters[$match[1]] = $this->parseValue($match[2]);
                }
            } else if(preg_match("/^" . SELF::KEY_PATTERN . "$/", $rawParameter, $match)) {
                $this->parameters[$rawParameter] = TRUE;
            } else {
                $this->parameters[$rawParameter] = NULL;
            }
        }
    }

    /**
     * Parse a row value as a JSON object
     *
     * @param string $originalValue
     * @return mixed|null
     */
    private function parseValue($originalValue) {
        $value = NULL;

        if($originalValue && $originalValue !== 'null') {
            if( ($json = json_decode($originalValue, TRUE)) === NULL) {
                $value = $originalValue;
            } else {
                $value = $json;
            }
        }

        return $value;
    }
}
