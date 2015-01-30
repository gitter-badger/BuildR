<?php namespace buildr\Utils\System\Modules;
use buildr\Utils\System\SystemUtils;

/**
 * BuildR - PHP based continuous integration server
 *
 * Base modules for all SystemSupport module
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System\Modules
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class BaseSystemModule {

    /**
     * @type string
     */
    public $moduleName = "";

    /**
     * @type array
     */
    protected $supportedSystems = [];

    /**
     * @type array
     */
    protected $testFunctions = [];

    /**
     * @type null
     */
    private $errorFunction = NULL;

    /**
     * Constructor
     */
    public function __construct() {
        $this->runFunctionTest();
    }

    /**
     * Get load stat of this extension
     *
     * @return bool
     */
    public function isLoaded() {
        return extension_loaded($this->moduleName);
    }

    /**
     * Get the system support for this extension
     *
     * @return bool
     */
    public function isSupportedBySystem() {
        $currentOS = SystemUtils::getOsType();

        return in_array($currentOS, $this->supportedSystems);
    }

    /**
     * Run test for the given function from extension
     *
     * @return bool
     */
    private function runFunctionTest() {
        foreach($this->testFunctions as $function) {
            if(!function_exists($function)) {
                $this->errorFunction = $function;
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Get the extension is supported
     *
     * @return bool
     */
    public function isSupported() {
        if(($this->isSupportedBySystem() === TRUE) && ($this->isLoaded() === TRUE) && ($this->errorFunction === NULL)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get the reason why this module not supported. Return messages as array
     *
     * @return array
     */
    public function getUnSupportReason() {
        if(($this->isLoaded() === FALSE) && ($this->isSupportedBySystem() === FALSE) && ($this->errorFunction !== NULL)) {
            return ["This extension is not loaded!", "This system not support this extension!", "The following test function ({$this->errorFunction}) not found!"];
        }

        if(!$this->isLoaded()) {
            return ["This extension is not loaded!"];
        }

        if(!$this->isSupportedBySystem()) {
            return ["This system not support this extension!"];
        }

        if($this->errorFunction !== NULL) {
            return ["The following test function ({$this->errorFunction}) not found!"];
        }

        return [];
    }


}