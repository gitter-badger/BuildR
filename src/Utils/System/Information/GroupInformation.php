<?php namespace buildr\Utils\System\Information;

use buildr\Utils\System\SystemUtils;
use buildr\Utils\System\Modules\PosixModule;

/**
 * BuildR - PHP based continuous integration server
 *
 * Get information about *Nix system groups
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System\Information
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @property-read string name The name of this group
 * @property-read array members An array, contains all members from this group
 * @property-read string gid The numerical ID of this group
 */
class GroupInformation {

    /**
     * @type int
     */
    public $groupId;

    /**
     * @type array
     */
    private $posixInfoArray;

    /**
     * Get the group information by a group name, or group ID
     *
     * @param int|string $group
     * @throws \buildr\Utils\System\Exception\ModuleNotSupportedException
     */
    public function __construct($group) {
        SystemUtils::getExtensionSupport([PosixModule::class])[PosixModule::MODULE_NAME];

        if(is_numeric($group)) {
            $this->groupId = (int) $group;
            $this->posixInfoArray = posix_getgrgid($this->groupId);
        } else {
            $this->posixInfoArray = posix_getgrnam($group);
            $this->groupId = $this->gid;
        }
    }

    /**
     * Magic getter to read property array, returned by posix_* function
     *
     * @param $property
     * @return null
     */
    public function __get($property) {
        if(isset($this->posixInfoArray[$property])) {
            return $this->posixInfoArray[$property];
        }

        return NULL;
    }

}
