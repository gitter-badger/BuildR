<?php namespace buildr\Logger\Attachment;

/**
 * Attachment interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Attachment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface AttachmentInterface {

    /**
     * Return an unique identifier for this attachment
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Return attachment value as string
     *
     * @return string
     */
    public function getValue();

}
