<?php namespace buildr\Filesystem;

/**
 * Filesystem Interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Filesystem
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface FilesystemInterface {

    /**
     * Return the project absolute root path
     *
     * @return string
     */
    public static function getProjectAbsoluteRoot();

    /**
     * Assemble dire by system-safe separator
     *
     * @param array $directoryParts
     *
     * @return string
     */
    public static function assembleDirSystemSafe(array $directoryParts);

    /**
     * Normalize directory, or file name by replacing any slashes to system-proper directory separator
     *
     * @param $path
     *
     * @return mixed
     */
    public function normalizeSlashes($path);

    /**
     * Make a directory, or file location to absolute from a relative location
     *
     * @param $location
     *
     * @return string
     */
    public function makeAbsolute($location);

    /**
     * Touches a file. If not exist, it will create, or set the modification time
     * to current system time
     *
     * @param string $location relative to project absolute root
     * @param string $fileName
     *
     * @return bool
     */
    public function touch($location, $fileName);

    /**
     * Get a File object for the specified file, that allows more
     * in-depth interaction with that file
     *
     * @param string $fileLocation
     *
     * @return \buildr\Filesystem\Types\File
     */
    public function getFile($fileLocation);

    /**
     * Get a Directory object for the specified directory, that allows more
     * in-depth interaction with it
     *
     * @param string $directory
     *
     * @return \buildr\Filesystem\Types\Directory
     */
    public function getDirectory($directory);

}
