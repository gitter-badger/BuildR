<?php namespace buildr\Http\Response\ContentType\Encoder;

/**
 * JSON content encoder
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
class JsonContentEncoder implements HttpContentEncoderInterface {

    /**
     * Return the properly encoded and filtered content
     *
     * @param mixed $content
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function encode($content) {
        if(!is_resource($content)) {
            return json_encode($content,
                JSON_HEX_TAG
                | JSON_HEX_APOS
                | JSON_HEX_AMP
                | JSON_HEX_QUOT);
        }

        throw new \InvalidArgumentException('JSON responses can\'t take resource types!');
    }

}
