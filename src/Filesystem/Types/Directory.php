<?php namespace buildr\Filesystem\Types;

/**
 * Directory filesystem type
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
class Directory extends FilesystemType {

    use PermissionsTrait;
    use SizeFormattingTrait;

    /**
     * @type string
     */
    protected $absoluteLocation;

    /**
     * @param string $directory
     */
    public function __construct($directory) {
        $this->absoluteLocation = $directory;
    }

    /**
     * Returns the current directory size.
     *
     * @param bool $humanReadable
     * @param int $precision
     * @param bool $showUnits
     *
     * @return string
     */
    public function getSize($humanReadable = TRUE, $precision = 2, $showUnits = TRUE) {
        $size = 0;

        foreach($this->getRecursiveIterator() as $infoObject){
            $size += $infoObject->getSize();
        }

        return $this->formatSize($size, $humanReadable, $precision, $showUnits);
    }

    /**
     * Iterate trough all file in the directory, only dig down to given depth
     *
     * @param callable $callback
     * @param int $maxDepth
     */
    public function iterate(callable $callback, $maxDepth = -1) {
        $iterator = $this->getRecursiveIterator();
        $maxDepth = $maxDepth;

        if($maxDepth == -1) {
            $maxDepth = 9999999;
        }

        $iterator->setMaxDepth($maxDepth);

        foreach($iterator as $infoObject) {
            $currentDepth = $iterator->getDepth();
            call_user_func_array($callback, [$infoObject, $currentDepth]);
        }
    }

    /**
     * Iterate trough all file in the directory, and filter them using regex,
     * only dig down to given depth
     *
     * @param callable $callback
     * @param string $pattern
     * @param int $maxDepth
     */
    public function filter(callable $callback, $pattern, $maxDepth = -1) {
        $iterator = $this->getRecursiveIterator();

        $maxDepth = $maxDepth;

        if($maxDepth == -1) {
            $maxDepth = 9999999;
        }

        $iterator->setMaxDepth($maxDepth);

        $regexIterator = new \RegexIterator($iterator, $pattern);

        foreach($regexIterator as $fileInfo) {
            $currentDepth = $iterator->getDepth();
            call_user_func_array($callback, [$fileInfo, $currentDepth]);
        }
    }

    /**
     * Return a RecursiveIteratorIterator for current folder
     * to help iteration functions
     *
     * @return \RecursiveIteratorIterator
     */
    private function getRecursiveIterator() {
        return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->absoluteLocation, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
    }

}
