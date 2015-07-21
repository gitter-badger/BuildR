<?php namespace buildr\Http\Response\ContentType;

use buildr\Http\Response\ContentType\HttpContentTypeInterface;
use buildr\Application\Application;
use buildr\Http\Header\Writer\JsonHeaderWriter;
use buildr\Http\Response\ContentType\Encoder\JsonContentEncoder;

/**
 * JSON content type
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Response\ContentType
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class JsonContentType implements HttpContentTypeInterface {

    /**
     * Returns the MIME type for the response header
     *
     * @return string
     */
    public function getMimeType() {
        return 'application/json';
    }

    /**
     * Returns the encoder for ths content type. If this NULL it means that this content
     * type not need special encoding before write out.
     *
     * All encoder must be taken out from the container
     *
     * @return NULL|\buildr\Http\Response\ContentType\Encoder\HttpContentEncoderInterface
     */
    public function getEncoder() {
        return Application::getContainer()->construct(JsonContentEncoder::class);
    }

    /**
     * Return the header writer for this content type
     *
     * All writer MUST be resolved from the Container.
     *
     * @return \buildr\Http\Header\Writer\HeaderWriterInterface
     */
    public function getHeaderWriter() {
        return Application::getContainer()->construct(JsonHeaderWriter::class);
    }

}
