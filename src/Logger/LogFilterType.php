<?php namespace buildr\Logger;

use buildr\Utils\Enum\BaseEnumeration;

/**
 * BuildR - PHP based continuous integration server
 *
 * Log filter type enumeration
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class LogFilterType extends BaseEnumeration {

    const FILTER_ABOVE = "ABOVE";

    const FILTER_BELOW = "BELOW";

    const FILTER_SAME = "SAME";

}
