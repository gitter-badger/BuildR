<?php namespace buildr\Utils\System\Exception;

use Exception;

/**
 * BuildR - PHP based continuous integration server
 *
 * ModuleNotSupportedException
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System\Exception
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ModuleNotSupportedException extends \Exception {

    /**
     * @type string
     */
    private $moduleName;

    /**
     * @types string
     */
    private $reasonArray = [];

    /**
     * Constructor
     *
     * @param string $moduleName
     * @param array $reasonArray
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($moduleName, $reasonArray, $message = "", $code = 0, Exception $previous = NULL) {
        $this->moduleName = $moduleName;
        $this->reasonArray = $reasonArray;

        parent::__construct($message, $code, $previous);
    }

    public function getModuleName() {
        return $this->moduleName;
    }

    public function getReasons() {
        return $this->reasonArray;
    }
}
