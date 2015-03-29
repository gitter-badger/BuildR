<?php namespace buildr\Logger\Handler;

use buildr\Logger\LogFilterType;
use buildr\Logger\Logger;

/**
 * BuildR - PHP based continuous integration server
 *
 * FilterableHandler trait
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Handler
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
trait FilterableHandlerTrait {

    private $handledLevels = NULL;

    /**
     * Set the level filter for the current handler
     *
     * @param $level
     * @param \buildr\Logger\LogFilterType $filterType
     * @return mixed
     */
    public function setFilter($level, LogFilterType $filterType) {
        $allLevels = Logger::$levels;
        $part = $allLevels[$level];

        switch ($filterType) {
            case LogFilterType::FILTER_ABOVE:
                $this->handledLevels = array_slice($allLevels, 0, $part + 1);
                break;
            case LogFilterType::FILTER_BELOW:
                $this->handledLevels = array_slice($allLevels, $part, -1);
                break;
            default:
                $this->handledLevels = array_slice($allLevels, $part, 1);
                break;
        }
    }

    /**
     * Remove all filtering from the handler. It means the handler can handle all levels
     *
     * @return void
     */
    public function removeFilter() {
        $this->handledLevels = NULL;
    }

    /**
     * Determine if the handler handle the given level, with the current filtering settings
     *
     * @param int $level
     * @return bool
     */
    public function isHandleThisLevel($level) {
        /* If no filter specified always returns true */
        if($this->handledLevels === NULL) {
            return TRUE;
        }

        $levelIndex = Logger::$levels[$level];
        return in_array($levelIndex, $this->handledLevels);
    }

    /**
     * Return all handled levels
     *
     * @return array
     */
    public function getHandledLevels() {
        return $this->handledLevels;
    }

}
