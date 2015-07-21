<?php namespace buildr\Http\Header\Writer;

use buildr\Http\Header\HeaderBag;
use buildr\Http\Header\Writer\HeaderWriterInterface;
use buildr\Http\Header\ResponseHeaderBag;

/**
 * HTML header writer
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Response\Header\Writer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class JsonHeaderWriter implements HeaderWriterInterface {

    /**
     * Write out the headers and return the result. If the result is boolean
     * or NULL it means that the headers is sent. If is array or any other type
     * the returned result needs to be appended to response body.
     *
     * The data, that the writer returned must be the same type, as the connected
     * content type. In the response preparation phase, the returned date
     * prepended to UN-ENCODED content using a + operator. And after
     * the preparation the full content will be encoded.
     *
     * @param \buildr\Http\Header\ResponseHeaderBag $headerBag
     *
     * @return bool|NULL|mixed
     */
    public function write(ResponseHeaderBag $headerBag) {
        $headers = [];

        //write out the first line
        header(
            $headerBag->get(HeaderBag::HEADER_PROTOCOL). ' ' .
            $headerBag->get(HeaderBag::HEADER_STATUS_CODE) . ' ' .
            $headerBag->get(HeaderBag::HEADER_STATUS_TEXT),
            TRUE
        );

        //Put it to returns
        $headers[] = ['protocol' => $headerBag->get(HeaderBag::HEADER_PROTOCOL)];
        $headers[] = ['Status-Code' => $headerBag->get(HeaderBag::HEADER_STATUS_CODE)];
        $headers[] = ['StatusText' => $headerBag->get(HeaderBag::HEADER_STATUS_TEXT)];

        //Unset
        $headerBag->remove(HeaderBag::HEADER_PROTOCOL);
        $headerBag->remove(HeaderBag::HEADER_STATUS_CODE);
        $headerBag->remove(HeaderBag::HEADER_STATUS_TEXT);

        foreach($headerBag->getIterator() as $headerName => $headerValue) {
            header($headerName . ': ' . $headerValue);
            $headers[] = [$headerName => $headerValue];
        }

        return ['responseHeaders' => $headers];
    }

}
