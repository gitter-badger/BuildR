<?php namespace buildr\tests\http\Header;

use buildr\Http\Header\ResponseHeaderBag;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Header bag tests.
 *
 * This test class use the ResponseHeaderBag class for testing, but is the
 * child of the HeaderBag class, with som extended functionality.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class HeaderBagTest extends BuildRTestCase {

    /**
     * @type \buildr\Http\Header\ResponseHeaderBag
     */
    private $headerBag;

    private $dummyHeaders = [];

    public function setUp() {
        $this->dummyHeaders = [
            'Host' => 'dummy.tld',
            'Connection' => 'keep-alive',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9',
        ];

        $this->headerBag = new ResponseHeaderBag($this->dummyHeaders);

        parent::setUp();
    }

    public function testItReturnsAllHeader() {
        $this->assertEquals($this->dummyHeaders, $this->headerBag->getAll());
    }

    public function testItReturnsTheHeaderKeys() {
        $this->assertEquals(array_keys($this->dummyHeaders), $this->headerBag->keys());
    }

    public function testItReturnsTheIteratorCorrectly() {
        $this->assertInstanceOf(\Traversable::class, $this->headerBag->getIterator());
    }

    public function testHasFunctionality() {
        $this->assertTrue($this->headerBag->has('Host'));

        //The headers are ALWAYS case-sensitive
        $this->assertFalse($this->headerBag->has('host'));
        $this->assertFalse($this->headerBag->has('notExistHeader'));
    }

    public function testGetFunctionality() {
        $this->assertNull($this->headerBag->get('notExistHeader'));

        $this->assertEquals('dummy.tld', $this->headerBag->get('Host'));
        $this->assertEquals('Host: dummy.tld', $this->headerBag->get('Host', TRUE));
    }

    public function testAddingHeadersToStack() {
        $this->headerBag->add('Https', '1');

        $this->assertCount(4, $this->headerBag->getAll());
        $this->assertTrue($this->headerBag->has('Https'));
        $this->assertEquals('1', $this->headerBag->get('Https'));
    }

    public function testHeaderOverrideWorksProperly() {
        //Verify adding is successfully
        $this->headerBag->add('Https', '1');

        $this->assertTrue($this->headerBag->has('Https'));
        $this->assertEquals('1', $this->headerBag->get('Https'));

        //Try Override
        $this->headerBag->add('Https', 'newValue', FALSE);

        $this->assertEquals('1', $this->headerBag->get('Https'));

        //Override it (This is the default behaviour)
        $this->headerBag->add('Https', 'newValue');

        $this->assertCount(4, $this->headerBag->getAll());
        $this->assertEquals('newValue', $this->headerBag->get('Https'));
    }

    public function testRemovingFunctionality() {
        $this->headerBag->remove('Host');

        $this->assertCount(2, $this->headerBag->getAll());
    }

}
