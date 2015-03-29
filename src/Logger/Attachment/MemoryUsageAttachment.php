<?php namespace buildr\Logger\Attachment;

/**
 * BuildR - PHP based continuous integration server
 *
 * Memory usage attachment
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Attachment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class MemoryUsageAttachment implements AttachmentInterface {

    /**
     * Return an unique identifier for this attachment
     *
     * @return string
     */
    public function getIdentifier() {
        return "MEM_USAGE";
    }

    /**
     * Return attachment value as string
     *
     * @return string
     */
    public function getValue() {
        return memory_get_usage();
    }

}
