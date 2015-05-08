<?php namespace buildr\Event; 

/**
 * Event class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Event
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Event {

    /**
     * @type \buildr\Event\EventEmitter
     */
    private $emitter;

    public function __construct() {
        $this->emitter = new EventEmitter();
    }

    public function fire() {
        
    }

}
