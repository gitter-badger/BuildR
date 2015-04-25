<?php namespace buildr\Utils\Reflection\Annotation;

/**
 * Annotation Reader
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\Reflection\Annotation
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Reader {

    /**
     * @type \buildr\Utils\Reflection\Annotation\Parser
     */
    private $parser;

    /**
     * @type array
     */
    private $parsedResult;

    /**
     * Constructor
     *
     * @param string $rawDocBlock
     */
    public function __construct($rawDocBlock) {
        $this->parser = new Parser($rawDocBlock);
        $this->parsedResult = $this->parser->getResult();
    }

    /**
     * Return the parse result of the docblock
     *
     * @return array
     */
    public function getParams() {
        return $this->parsedResult;
    }

    /**
     * Return the given parameter value, or NULL if the
     * parameter not found
     *
     * @param string $paramName
     *
     * @return mixed
     */
    public function getParam($paramName) {
        if(isset($this->parsedResult[$paramName])) {
            return $this->parsedResult[$paramName];
        }

        return NULL;
    }

}
