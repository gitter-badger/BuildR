<?php namespace buildr\tests\environment\dummy;

use buildr\Startup\Environment\Detector\DetectorInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * DummyDetector
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\environment\dummy
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class DummyDetector  implements DetectorInterface {

    /**
     * Returns the detected environment as string
     *
     * @return string
     */
    public function detect() {
        return TRUE;
    }
}
