<?php namespace buildr\Filesystem\Types;

/**
 * Trait to easily implements file or directory size formation support
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
trait SizeFormattingTrait {

    /**
     * Format the given size (in kb) to a nice HumanReadable format
     *
     * @param float $size
     * @param bool $humanReadable
     * @param int $precision
     * @param bool $showUnits
     *
     * @return string
     */
    public function formatSize($size, $humanReadable = TRUE, $precision = 2, $showUnits = TRUE) {
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

}
