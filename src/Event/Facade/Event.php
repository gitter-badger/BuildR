<?php namespace buildr\Event\Facade;
use buildr\Facade\Facade;

/**
 * Event class facade
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Event\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Event extends Facade {

    public function getBindingName() {
        return 'event';
    }

}
