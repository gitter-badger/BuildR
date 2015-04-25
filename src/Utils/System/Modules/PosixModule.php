<?php namespace buildr\Utils\System\Modules;

use buildr\Utils\System\SystemUtils;

/**
 * Posix module helper for SystemSupport class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System\Module
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PosixModule extends BaseSystemModule {

    const MODULE_NAME = "posix";

    public $moduleName = "posix";

    protected $supportedSystems = [SystemUtils::OS_TYPE_NIX];

    protected $testFunctions = [
        "posix_access",
        "posix_geteuid",
        "posix_kill",
        "posix_times",
        "posix_uname"
    ];

}
