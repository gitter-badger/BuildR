<?php namespace buildr\tests\filesystem;

use buildr\Filesystem\Filesystem;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * Directory Object tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Test\Filesystem
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class DirectoryObjectTest extends BuilderTestCase {

    /**
     * @type \buildr\Filesystem\Types\Directory
     */
    private $directoryObject;

    public function setUp() {
        $fs = new Filesystem();

        $this->directoryObject = $fs->getDirectory('tests/filesystem_fixtures');

        parent::setUp();
    }

    public function testSummarizeSizeCorrectly() {
        $this->assertEquals("10.04 kB", $this->directoryObject->getSize());
        $this->assertEquals("10.04", $this->directoryObject->getSize(TRUE, 2, FALSE));
        $this->assertEquals("10", $this->directoryObject->getSize(TRUE, 0, FALSE));
        $this->assertEquals("10283", $this->directoryObject->getSize(FALSE));
    }

    public function testItIteratesCorrectly() {
        $this->directoryObject->iterate(function(\SplFileInfo $info, $dept) {
            $this->assertInstanceOf(\SplFileInfo::class, $info);
            $this->assertTrue(is_int($dept));
        });
    }

    public function testItIterateThroughGivenDepth() {
        $this->directoryObject->iterate(function(\SplFileInfo $info, $depth) {
            $this->assertEquals(0, $depth);
        }, 0);
    }

    public function testItFiltersCorrectly() {
        $count = 0;

        $this->directoryObject->filter(function(\SplFileInfo $info, $depth) use (&$count) {
            $count++;
        }, '/\b(gitkeep)\b/i');

        $this->assertEquals(2, $count);
    }

    public function testItFiltersCorrectlyWithLimitedDepth() {
        $count = 0;

        $this->directoryObject->filter(function(\SplFileInfo $info, $depth) use (&$count) {
            $count += 1;
        }, '/\b(gitkeep)\b/i', 0);

        $this->assertEquals(1, $count);
    }

}
