<?php namespace buildr\Filesystem\Types;

/**
 * File type handler
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Filesystem\Types
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class File {

    use PermissionsTrait;

    /**
     * @type string
     */
    private $fileLocation;

    /**
     * Constructor
     *
     * @param string $fileLocation
     */
    public function __construct($fileLocation) {
        $this->fileLocation = $fileLocation;
    }

    /**
     * Return the full contents of the file
     *
     * @return string
     */
    public final function getContent() {
        return file_get_contents($this->fileLocation);
    }

    /**
     * Put new content to the file, by replacing all existing
     * content using file_put_contents() function
     *
     * @param string $content
     *
     * @return int
     */
    public final function put($content) {
        return file_put_contents($this->fileLocation, $content);
    }

    /**
     * Put content to file, after the existing content using
     * file_put_contents() function and the FILE_APPEND PHP flag
     *
     * @param string $content
     *
     * @return int
     */
    public final function append($content) {
        return file_put_contents($this->fileLocation, $content, FILE_APPEND);
    }

    /**
     * Put the new content before the existing content (If exists)
     * Basically its get the original content, and concatenate with the
     * new content
     *
     * @param string $content
     *
     * @return int
     */
    public final function prepend($content) {
        $existingContent = $this->getContent();
        $content = $content . $existingContent;

        return $this->put($content);
    }

    /**
     * Get the PHP resource for this file, with the given mode
     *
     * @param string $mode
     *
     * @return resource
     */
    public final function getResource($mode = "a+") {
        return fopen($this->fileLocation, $mode);
    }

    /**
     * If this is a PHP file, and returns something, you use this
     * method to get the returned content
     *
     * @return mixed
     */
    public final function getRequire() {
        return require $this->fileLocation;
    }

    /**
     * Include this file to the include_path, its basically simple
     * requiring the file
     *
     * @return mixed
     */
    public final function requireOnce() {
        return require_once $this->fileLocation;
    }

    /**
     * Returns the SplFileInfo object for this file
     *
     * @return \SplFileInfo
     */
    public final function getFileInfo() {
        return new \SplFileInfo($this->fileLocation);
    }

    /**
     * Get the size of the current file
     *
     * @param bool $humanReadable Return size in human readable format instead of bytes
     * @param int $precision
     * @param bool $showUnits Display units?
     *
     * @return string
     */
    public function getSize($humanReadable = TRUE, $precision = 2, $showUnits = TRUE) {
        $size = filesize($this->fileLocation);

        if($humanReadable === FALSE) {
            return $size;
        }

        $sizeUnits = [
            "B",
            "kB",
            "MB",
            "GB",
            "TB",
            "PB"
        ];
        $factor = floor((strlen($size) - 1) / 3);

        if($showUnits === TRUE) {
            return sprintf("%.{$precision}f", $size / pow(1024, $factor)) . " " . $sizeUnits[$factor];
        }

        return sprintf("%.{$precision}f", $size / pow(1024, $factor));
    }

    /**
     * Truncates the file content
     *
     * @return bool
     */
    public final function truncate() {
        return ftruncate($this->getResource("r+"), 0);
    }

    /**
     * Removes this file
     *
     * @return bool
     */
    public final function remove() {
        return unlink($this->fileLocation);
    }

    /**
     * Moves this file across the filesystem using php rename() method
     *
     * @param string $absolutePath
     *
     * @return bool
     */
    public final function move($absolutePath) {
        $fileInfo = $this->getFileInfo();
        $newFile = $absolutePath . DIRECTORY_SEPARATOR . $fileInfo->getFilename();

        return rename($this->fileLocation, $newFile);
    }

    /**
     * Copy this file across filesystem using PHP copy() method
     *
     * @param string $absolutePath
     *
     * @return bool
     */
    public final function copy($absolutePath) {
        $fileInfo = $this->getFileInfo();
        $newFile = $absolutePath . DIRECTORY_SEPARATOR . $fileInfo->getFilename();

        return copy($this->fileLocation, $newFile);
    }

}
