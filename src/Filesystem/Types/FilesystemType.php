<?php namespace buildr\Filesystem\Types;

/**
 * Base class for filesystem types (such as File and Directory)
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
class FilesystemType {

    /**
     * Returns the SplFileInfo for this object
     *
     * @return \SplFileInfo
     */
    public final function getSplInfo() {
        return new \SplFileInfo($this->absoluteLocation);
    }

}
