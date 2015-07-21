<?php namespace buildr\tests\http\Response;

use buildr\Http\Constants\HttpProtocolVersion;
use buildr\Http\Constants\HttpResponseCode;
use buildr\Http\Header\ResponseHeaderBag;
use buildr\Http\Response\ContentType\PlaintextContentType;
use buildr\Http\Header\HeaderBag;
use buildr\Http\Response\ContentType\HtmlContentType;
use buildr\Http\Response\ContentType\HttpContentTypeInterface;
use buildr\Http\Response\ContentType\JsonContentType;use buildr\Http\Response\Response;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * HTTP response test
 *
 * @
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Response
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ResponseTest extends BuildRTestCase {

    /**
     * @type \buildr\Http\Response\Response
     */
    private $response;

    public function setUp() {
        $dummyHeaderBag = new ResponseHeaderBag([
            HeaderBag::HEADER_PROTOCOL => 'HTTP/1.1',
            HeaderBag::HEADER_STATUS_CODE => 200,
            HeaderBag::HEADER_STATUS_TEXT => 'Ok',
            'Host' => 'http://host.tld',
            'Content-Type' => 'application/json'
        ]);

        $this->response = new Response($dummyHeaderBag);

        parent::setUp();
    }

    public function testItCreatesAnEmptyHeaderBagIfNoOneSpecified() {
        $response = new Response();

        $this->assertInstanceOf(ResponseHeaderBag::class, $response->getHeaderBag());
    }

    public function testItFillTheBodyPropertiesCorrectly() {
        $this->response->setBody('Hello World');

        $body = $this->getPrivatePropertyFromClass(Response::class, 'body', $this->response);

        $this->assertEquals('Hello World', $body);
        $this->assertEquals('Hello World', $this->response->getRawBody());
    }

    public function testItSetTheProtocolVersionCorrectly() {
        $this->response->setProtocolVersion(HttpProtocolVersion::HTTP_PROTOCOL_VERSION_2());

        $version = $this->getPrivatePropertyFromClass(Response::class, 'protocolVersion', $this->response);

        $this->assertEquals((string) HttpProtocolVersion::HTTP_PROTOCOL_VERSION_2(), $version);
    }

    public function testItSetTheStatusCorrectly() {
        $this->response->setStatusCode(HttpResponseCode::HTTP_ACCEPTED());

        $statusCode = $this->getPrivatePropertyFromClass(Response::class, 'statusCode', $this->response);
        $statusText = $this->getPrivatePropertyFromClass(Response::class, 'statusText', $this->response);

        $this->assertEquals('202', $statusCode);
        $this->assertEquals('Accepted', $statusText);
    }

    public function testStatusTextOverWriteFunctionDisability() {
        $this->response->setStatusText('HelloStatusOverride');
        $this->response->setStatusCode(HttpResponseCode::HTTP_ACCEPTED(), TRUE);

        $statusCode = $this->getPrivatePropertyFromClass(Response::class, 'statusCode', $this->response);
        $statusText = $this->getPrivatePropertyFromClass(Response::class, 'statusText', $this->response);

        $this->assertEquals('202', $statusCode);
        $this->assertEquals('HelloStatusOverride', $statusText);
    }

    public function testItSetsTheContentTypeCorrectly() {
        $this->response->setContentType(new HtmlContentType());

        $contentType = $this->getPrivatePropertyFromClass(Response::class, 'contentType', $this->response);
        $contentTypeText = $this->getPrivatePropertyFromClass(Response::class, 'contentTypeString', $this->response);

        $this->assertInstanceOf(HttpContentTypeInterface::class, $contentType);
        $this->assertEquals('text/html', $contentTypeText);
    }

    public function testContentTypeTextOverrideCorrectly() {
        $this->response->setContentTypeString('custom/mime');
        $this->response->setContentType(new JsonContentType(), TRUE);

        $contentType = $this->getPrivatePropertyFromClass(Response::class, 'contentType', $this->response);
        $contentTypeText = $this->getPrivatePropertyFromClass(Response::class, 'contentTypeString', $this->response);

        $this->assertInstanceOf(JsonContentType::class, $contentType);
        $this->assertEquals('custom/mime', $contentTypeText);
    }

    /**
     * @runInSeparateProcess
     */
    public function testItSendsTheResponseCorrectly() {
        $this->response->setBody('Hello World');
        $result = (string) $this->response;

        $statusCode = $this->getPrivatePropertyFromClass(Response::class, 'statusCode', $this->response);
        $statusText = $this->getPrivatePropertyFromClass(Response::class, 'statusText', $this->response);

        $contentType = $this->getPrivatePropertyFromClass(Response::class, 'contentType', $this->response);
        $contentTypeText = $this->getPrivatePropertyFromClass(Response::class, 'contentTypeString', $this->response);

        //Sets the default status
        $this->assertEquals(200, $statusCode);
        $this->assertEquals('Ok', $statusText);

        //Sets the default
        $this->assertInstanceOf(PlaintextContentType::class, $contentType);
        $this->assertEquals('text/plain', $contentTypeText);

        //Set the Content-Type header in headerBag
        $this->assertEquals('text/plain', $this->response->getHeaderBag()->get('Content-Type'));

        //Count headers
        $headerList = [];

        if(extension_loaded('xdebug')) {
            $headerList = xdebug_get_headers();
        } else {
            $this->markTestIncomplete('Please install XDebug extension!');
        }

        $this->assertCount(2, $headerList);
    }

    /**
     * @runInSeparateProcess
     */
    public function testItSendTheResponseCorrectlyWithAdditionalHeaderAndEncoding() {
        $this->response->setBody(['Hello' => 'World']);
        $this->response->setContentType(new JsonContentType());

        $result = $this->response->send();

        $this->assertJson($result);
    }

}
