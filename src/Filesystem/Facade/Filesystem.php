<?php namespace buildr\Filesystem\Facade;

use buildr\Facade\Facade;

/**
 * BuildR - PHP based continuous integration server
 *
 * Facade for filesystem class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Filesystem\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @method static string getProjectAbsoluteRoot() Return the absolute root path of this project
 * @method static string assembleDirSystemSafe(array $directoryParts) Assemble the given parts by proper DIRECTORY_SEPARATOR
 * @method static string normalizeSlashes($path) Normalize directory, or file name by replacing any slashes to system-proper directory separator
 * @method static \buildr\Filesystem\Types\File getFile(string $fileLocation) Get a File object for the specified file, that allows more in-depth interaction with that file
 * @method static bool touch(string $fileLocation) Touches the file, and creates when its not exits
 * @method static string makeAbsolute(string $location) Makes a location to absolute link
 * @method string bool touch($fileLocation) Touches a file. If not exist, it will create, or set the modification time to current system time
 *
 * @codeCoverageIgnore
 */
class Filesystem extends Facade {

    public static function getBindingName() {
        return "filesystem";
    }

}
