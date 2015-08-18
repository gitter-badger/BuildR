<?php namespace buildr\tests\http\Uri; 

use buildr\Http\Uri\Uri;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Uri component test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Uri
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class UriTest extends BuildRTestCase {

    /**
     * @type string
     */
    private $uriValidPort;

    /**
     * @type \buildr\Http\Uri\Uri
     */
    private $uriInstanceValidPort;

    /**
     * @type string
     */
    private $uriInvalidPort;

    /**
     * @type \buildr\Http\Uri\Uri
     */
    private $uriInstanceInvalidPort;

    public function setUp() {
        $this->uriValidPort = 'https://user:pass@secure.domain.org/hello/world?param=value&anotherparam=anotherValue';
        $this->uriInstanceValidPort = new Uri($this->uriValidPort);

        $this->uriInvalidPort ='http://secure.domain.org:587/hel@+%lo/wor@d?par+am=val@ueValue#mark';
        $this->uriInstanceInvalidPort = new Uri($this->uriInvalidPort);

        parent::setUp();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Failed to parse the given URI!
     */
    public function testItThrowsExceptionWhenGiveInvalidUri() {
        new Uri('wrong url');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The specified port (65540) is not a valid TCP/UDP port!
     */
    public function testItThrowsExceptionWhenPortIsOutOfRange() {
        $this->uriInstanceInvalidPort->withPort('65540');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This scheme (ooops) is not supported!
     */
    public function testItThrowsExceptionWhenAnUnsupportedSchemeSpecified() {
        $this->uriInstanceInvalidPort->withScheme('ooops');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The $path parameter mut be a string!
     */
    public function testItThrowsExceptionWhenCopyWithInvalidPath() {
        $this->uriInstanceInvalidPort->withPath(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The new path cant contains query string!
     */
    public function testItThrowsExceptionWhenCopyWithInvalidPathThatContainsQuery() {
        $this->uriInstanceInvalidPort->withPath('/as/as?param=val');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The $query parameter mut be a string!
     */
    public function testItThrowsExceptionWhenCopyWithInvalidQueryThatNotString() {
        $this->uriInstanceInvalidPort->withQuery(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The new query cant contains url fragment!
     */
    public function testItThrowsExceptionWhenCopyWithInvalidQueryThatContainsFragments() {
        $this->uriInstanceInvalidPort->withQuery('new=query?another=param#fragment');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The new path cant contains url fragment!
     */
    public function testItThrowsExceptionWhenCopyWithInvalidPathThatContainsFragment() {
        $this->uriInstanceInvalidPort->withPath('/as/as#fragment');
    }

    public function testAllMutatorsAndStringCastingWorksCorrectly() {
        $clone = $this->uriInstanceValidPort
            ->withQuery('new=param&another=query')
            ->withPath('/new/path')
            ->withUserInfo('testUser')
            ->withHost('dummy.host')
            ->withFragment('section')
            ->withPort('25565')
            ->withScheme('https');

        $this->assertEquals('https://testUser@dummy.host:25565/new/path?new=param&another=query#section', (string) $clone);
    }

    public function testItCorrectlyResolvesTheScheme() {
        $this->assertEquals('https', $this->uriInstanceValidPort->getScheme());
        $this->assertEquals('http', $this->uriInstanceInvalidPort->getScheme());
    }

    public function testItCorrectlyResolvesTheAuthority() {
        $this->assertEquals('user:pass@secure.domain.org', $this->uriInstanceValidPort->getAuthority());
        $this->assertEquals('secure.domain.org:587', $this->uriInstanceInvalidPort->getAuthority());
    }

    public function testItCorrectlyResolvesTheUserInfo() {
        $this->assertEquals('user:pass', $this->uriInstanceValidPort->getUserInfo());
        $this->assertEquals('', $this->uriInstanceInvalidPort->getUserInfo());

        $clone = $this->uriInstanceInvalidPort->withUserInfo('newUser');
        $this->assertEquals('newUser', $clone->getUserInfo());

        $cloneUserAndPassword = $this->uriInstanceInvalidPort->withUserInfo('newUser', 'newPassword');
        $this->assertEquals('newUser:newPassword', $cloneUserAndPassword->getUserInfo());
    }

    public function testItCorrectlyResolvesTheHost() {
        $this->assertEquals('secure.domain.org', $this->uriInstanceValidPort->getHost());

        $clone = $this->uriInstanceValidPort->withHost('UPPERCASE');

        //ctype_lower() not detects the '.' as lowercase character, so we strip this out for this test
        $newHost = str_replace('.', '', $clone->getHost());
        $this->assertTrue(ctype_lower($newHost));
    }

    public function testItCorrectlyResolvesThePort() {
        //From specified port
        $this->assertEquals('587', $this->uriInstanceInvalidPort->getPort());

        //From scheme
        $this->assertEquals('443', $this->uriInstanceValidPort->getPort());
    }

    public function testItCorrectlyResolvesThePath() {
        $this->assertEquals('/hel%40%2B%25lo/wor%40d', $this->uriInstanceInvalidPort->getPath());

        $cloneEmptyPath = $this->uriInstanceInvalidPort->withPath('');
        $this->assertEquals('/', $cloneEmptyPath->getPath());

        $cloneRootPath = $this->uriInstanceInvalidPort->withPath('/');
        $this->assertEquals('/', $cloneRootPath->getPath());
    }

    public function testItCorrectlyResolvesTheQueryString() {
        $this->assertEquals('param=value&anotherparam=anotherValue', $this->uriInstanceValidPort->getQuery());
        $this->assertEquals('par%2Bam=val%40ueValue', $this->uriInstanceInvalidPort->getQuery());

        $cloneEmptyQuery = $this->uriInstanceInvalidPort->withQuery('');
        $this->assertEquals('', $cloneEmptyQuery->getQuery());

        $cloneNoValue = $this->uriInstanceInvalidPort->withQuery('asd+');
        $this->assertEquals('asd%2B', $cloneNoValue->getQuery());
    }

    public function testItCorrectlyResolvesTheFragment() {
        $this->assertEquals('mark', $this->uriInstanceInvalidPort->getFragment());

        $cloneEncodedFragment = $this->uriInstanceInvalidPort->withFragment('mark+');
        $this->assertEquals('mark%2B', $cloneEncodedFragment->getFragment());
    }

    public function testItShouldReturnAnEmptyHostIfNoOneSpecified() {
        $res = $this->invokePrivateMethod(get_class($this->uriInstanceInvalidPort), 'getFilteredHost', [NULL]);

        $this->assertEquals('', $res);
    }

    public function testItReturnsAnEmptyStringWhenTheQueryIsNull() {
        $res = $this->invokePrivateMethod(get_class($this->uriInstanceInvalidPort), 'getFilteredQuery', [NULL]);

        $this->assertEquals('', $res);
    }

    public function testItNotEncodeTheAlreadyEncodedStrings() {
        $res = $this->invokePrivateMethod(get_class($this->uriInstanceInvalidPort), 'filterFragment', ['Hello%40World']);

        $this->assertEquals('Hello%40World', $res);
    }

    public function testItReturnsThePathSeparatorOnNullValuePath() {
        $res = $this->invokePrivateMethod(get_class($this->uriInstanceInvalidPort), 'getFilteredPath', [NULL]);

        $this->assertEquals('/', $res);
    }

    public function testPortFilteringShouldReturnNullWhenNoPortOrSchemeSpecifiedPort() {
        $res = $this->invokePrivateMethod(get_class($this->uriInstanceInvalidPort), 'getFilteredPort', [NULL]);

        $this->assertNull($res);
    }
}
