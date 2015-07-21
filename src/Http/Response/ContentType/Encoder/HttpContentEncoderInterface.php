<?php namespace buildr\Http\Response\ContentType\Encoder;

/**
 * Interface for various content encoders
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Response\ContentType\Encoder
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface HttpContentEncoderInterface {

    /**
     * Return the properly encoded and filtered content
     *
     * @param mixed $content
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function encode($content);

}
