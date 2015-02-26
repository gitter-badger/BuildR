<?php namespace buildr\Startup\Environment\Detector;

/**
 * BuildR - PHP based continuous integration server
 *
 * Interface for various environment detector
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Environment\Detector
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface DetectorInterface {

    /**
     * Returns the detected environment as string
     *
     * @return string
     */
    public function detect();

}
