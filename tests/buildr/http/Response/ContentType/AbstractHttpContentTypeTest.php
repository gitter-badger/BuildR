<?php namespace buildr\tests\http\Response\ContentType;

use buildr\Http\Response\ContentType\HttpContentTypeInterface;
use buildr\Http\Response\ContentType\Encoder\HttpContentEncoderInterface;
use buildr\Http\Header\Writer\HeaderWriterInterface;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Abstract class for Response content types test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Response\ContentType
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class AbstractHttpContentTypeTest extends BuildRTestCase {

    /**
     * @type \buildr\Http\Response\ContentType\HttpContentTypeInterface
     */
    private $contentType;

    public function setUp() {
        $this->contentType = $this->getClassInstance();

        parent::setUp();
    }

    /**
     * Return a new instance from the tested encoder class
     *
     * @return \buildr\Http\Response\ContentType\HttpContentTypeInterface
     */
    abstract public function getClassInstance();

    /**
     * Returns the current content type unique encoder class anem, or NULL
     * if the content type has no specific encoder
     *
     * @return string|NULL
     */
    abstract public function getEncoderName();

    /**
     * Return the associated header writer FQ class name.
     *
     * @return string|null
     */
    abstract function getHeaderWriterName();

    public function testIsCorrectlyImplementsTheInterface() {
        $this->assertInstanceOf(HttpContentTypeInterface::class, $this->contentType);
    }

    public function testItReturnsTheMimeTypeCorrectly() {
        $this->assertTrue(is_string($this->contentType->getMimeType()));

        //3 is the minimum length for content type mime (eg 'a/b')
        $this->assertGreaterThan(3, strlen($this->contentType->getMimeType()));
    }

    public function testItReturnsCorrectEncoder() {
        $encoder = $this->getEncoderName();

        if($encoder === NULL) {
            $this->assertNull($this->contentType->getEncoder());
        } else {
            $this->assertInstanceOf($encoder, $this->contentType->getEncoder());
            $this->assertInstanceOf(HttpContentEncoderInterface::class, $this->contentType->getEncoder());
        }
    }

    public function testItReturnsTheHeaderWriterCorrectly() {
        $writer = $this->getHeaderWriterName();

        if($writer === NULL) {
            $this->assertNull($this->contentType->getHeaderWriter());
        } else {
            $this->assertInstanceOf($writer, $this->contentType->getHeaderWriter());
            $this->assertInstanceOf(HeaderWriterInterface::class, $this->contentType->getHeaderWriter());
        }
    }

}
