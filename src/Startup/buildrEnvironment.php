<?php namespace buildr\Startup;

/**
 * BuildR - PHP based continuous integration server
 *
 * Environment handler
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class buildrEnvironment {

    public static final function detectEnvironment() {
        return "ENV_AS";
    }

}