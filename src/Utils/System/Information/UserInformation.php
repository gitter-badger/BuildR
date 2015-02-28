<?php namespace buildr\Utils\System\Information;

use buildr\Utils\System\SystemUtils;
use buildr\Utils\System\Modules\PosixModule;

/**
 * BuildR - PHP based continuous integration server
 *
 * Returns information absout a *nix user
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System\Information
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @property-read string uid The ID if the given user
 * @property-read string name The name of the user
 * @property-read string passwd The user password in encrypted format
 * @property-read string groupId The groupID of the current user
 * @property-read string gecos Return the other information from user, as a comma separated list
 * @property-read string dir The user home directory
 * @property-read string shell The user shell
 */
class UserInformation {

    /**
     * @type int
     */
    public $userId;

    /**
     * @type array
     */
    private $posixInfoArray;

    /**
     * Constructor
     *
     * @param int|string $user
     * @throws \buildr\Utils\System\Exception\ModuleNotSupportedException
     */
    public function __construct($user) {
        SystemUtils::getExtensionSupport([PosixModule::class])[PosixModule::MODULE_NAME];

        if(is_numeric($user)) {
            $this->userId = (int) $user;
            $this->posixInfoArray = posix_getpwuid($this->userId);
        } else {
            $this->posixInfoArray = posix_getpwnam($user);
            $this->userId = $this->uid;
        }
    }

    /**
     * Return entries from the posix information array
     *
     * @param string $property
     * @return null
     */
    public function __get($property) {
        if(isset($this->posixInfoArray[$property])) {
            return $this->posixInfoArray[$property];
        }

        return NULL;
    }

    /**
     * Return the user other information as an array
     *
     * @return array
     */
    public function getGecosAsArray() {
        return explode(",", $this->gecos);
    }
}
