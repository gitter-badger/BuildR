<?php namespace buildr\tests\filesystem;

use buildr\Filesystem\Filesystem;
use buildr\tests\Buildr_TestCase as BuilderTestCase;
use buildr\Utils\String\StringUtils;
use \buildr\Filesystem\Types\File;

/**
 * BuildR - PHP based continuous integration server
 *
 * Filyesystem class tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Filesystem
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class FilesystemTest extends BuilderTestCase {

    /**
     * @type \buildr\Filesystem\Filesystem;
     */
    protected $filesystem;

    protected function setUp() {
        $this->filesystem = new Filesystem();

        parent::setUp();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The given file is not found!
     */
    public function testGetFileObjectThrowsExceptionWhenFileNotFound() {
        $this->filesystem->getFile($this->filesystem->assembleDirSystemSafe(['tests', 'filesystem_fixtures', 'singleFileNotExist.txt']));
    }

    public function testItDetectsTheProperAbsoluteRoot() {
        $this->assertTrue(StringUtils::startWith($this->filesystem->getProjectAbsoluteRoot(), getcwd()));
    }

    public function testItNormalizeSeparatorsCorrectly() {
        $wrongPath = "home\\test\\\\my//location/path";
        $correctPath = $this->filesystem->assembleDirSystemSafe(['home', 'test', 'my', 'location', 'path']);
        $normalizedpath = $this->filesystem->normalizeSlashes($wrongPath);

        $this->assertEquals($correctPath, $normalizedpath);
    }

    public function testItMakesAbsolutePathCorrectly() {
        $alreadyAbsolutePath = $this->filesystem->getProjectAbsoluteRoot() . "home";
        $notAbsoluteLocation = "src" . DIRECTORY_SEPARATOR . "Startup";

        $this->assertEquals($alreadyAbsolutePath, $this->filesystem->makeAbsolute($alreadyAbsolutePath));
        $this->assertEquals($this->filesystem->getProjectAbsoluteRoot() . $notAbsoluteLocation, $this->filesystem->makeAbsolute($notAbsoluteLocation));
    }

    public function testItTouchesTheFileCorrectly() {
        $this->filesystem->touch("tests/filesystem_fixtures", "testFileTouch.txt");
        $expectedFileLocation = $this->filesystem->getProjectAbsoluteRoot() . $this->filesystem->normalizeSlashes("tests/filesystem_fixtures" . DIRECTORY_SEPARATOR . "testFileTouch.txt");

        $this->assertTrue(file_exists($expectedFileLocation));
        @unlink($expectedFileLocation);
    }

    public function testItReturnsTheProperFileObjectFromFile() {
        $file = $this->filesystem->getFile($this->filesystem->assembleDirSystemSafe(['tests', 'filesystem_fixtures', 'singleFile.txt']));
        $this->assertInstanceOf(File::class, $file);
    }
}
