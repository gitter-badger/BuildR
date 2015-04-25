<?php namespace buildr\Filesystem\Types;

use buildr\Utils\System\Exception\ModuleNotSupportedException;
use buildr\Utils\System\Information\GroupInformation;
use buildr\Utils\System\Information\UserInformation;

/**
 * Trait to easily implements fiel or directory permission info support
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
trait PermissionsTrait {

    /**
     * Get the group information about the current file, or directory group
     * If the function return 0, it means the the group selection is not successful
     *
     * @return \buildr\Utils\System\Information\GroupInformation|int
     */
    public final function getGroup() {
        $groupId = filegroup($this->fileLocation);

        if($groupId !== FALSE) {
            try {
                return new GroupInformation($groupId);
            } catch (ModuleNotSupportedException $e) {
                return $groupId;
            }
        }

        return 0;
    }

    /**
     * Get owner information about the current file ow directory
     * If this returns 0, it means the owner selection is not successful
     *
     * @return \buildr\Utils\System\Information\UserInformation|int
     */
    public function getOwner() {
        $ownerId = fileowner($this->fileLocation);

        if($ownerId !== FALSE) {
            try {
                return new UserInformation($ownerId);
            } catch (ModuleNotSupportedException $e) {
                return $ownerId;
            }
        }

        return 0;
    }

}
