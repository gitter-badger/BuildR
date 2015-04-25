<?php namespace buildr\Startup\Environment\Detector;

/**
 * Interface for various environment detector
 *
 * BuildR PHP Framework
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
