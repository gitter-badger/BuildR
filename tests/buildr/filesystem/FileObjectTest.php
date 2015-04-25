<?php namespace buildr\filesystem;

use buildr\tests\Buildr_TestCase as BuilderTestCase;
use buildr\Utils\StringUtils;
use buildr\Utils\System\Information\GroupInformation;
use buildr\Utils\System\Information\UserInformation;
use buildr\Utils\System\SystemUtils;

/**
 * File Object tests
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
class FileObjectTest extends BuilderTestCase {

    /**
     * @type \buildr\Filesystem\Types\File
     */
    private $fileObject;

    /**
     * @type \buildr\Filesystem\Types\File
     */
    private $fileObjectPhp;

    protected function setUp() {
        $filesystem = new Filesystem();
        $this->fileObject = $filesystem->getFile($filesystem->assembleDirSystemSafe([
            'tests',
            'filesystem_fixtures',
            'singleFile.txt'
        ]));
        $this->fileObjectPhp = $filesystem->getFile($filesystem->assembleDirSystemSafe([
            'tests',
            'filesystem_fixtures',
            'phpTest.php'
        ]));

        parent::setUp();
    }

    public function testItReturnsContentProperly() {
        $expectedContent = "initialContent";
        $readedContent = $this->fileObject->getContent();

        $this->assertEquals($expectedContent, $readedContent);
    }

    public function testItReturnsTheResourceProperly() {
        $this->assertTrue(is_resource($this->fileObject->getResource()));
    }

    public function testRequires() {
        $this->assertEquals("testContent", $this->fileObjectPhp->getRequire());
        $this->assertTrue($this->fileObjectPhp->requireOnce());
    }

    public function testIsReturnsFileInfoCorrectly() {
        $this->assertInstanceOf(\SplFileInfo::class, $this->fileObject->getFileInfo());
    }

    public function testItReturnsTheFileSizeCorrectlyAsHumanReadable() {
        $filesystem = new Filesystem();
        $testFile = $filesystem->getFile($filesystem->assembleDirSystemSafe([
            'tests',
            'filesystem_fixtures',
            '10KbFile.txt'
        ]));
        $sizeBytes = $testFile->getSize(FALSE);

        $this->assertEquals("10.00 kB", $testFile->getSize());
        $this->assertEquals("10.00", $testFile->getSize(TRUE, 2, FALSE));
        $this->assertEquals("10", $testFile->getSize(TRUE, 0, FALSE));
        $this->assertEquals("10239", $sizeBytes);
    }

    public function testItPutsContentCorrectly() {
        $originalContent = $this->fileObject->getContent();
        $this->fileObject->put("hello new content");

        $this->assertEquals("hello new content", $this->fileObject->getContent());
        $this->fileObject->put($originalContent);
    }

    public function testItAppendsContentCorrectly() {
        $originalContent = $this->fileObject->getContent();
        $this->fileObject->append(" test append");

        $this->assertEquals($originalContent . " test append", $this->fileObject->getContent());
        $this->fileObject->put($originalContent);
    }

    public function testItPrependsCorrectly() {
        $originalContent = $this->fileObject->getContent();
        $this->fileObject->prepend("test append ");

        $this->assertEquals("test append " . $originalContent, $this->fileObject->getContent());
        $this->fileObject->put($originalContent);
    }

    public function testTruncate() {
        $originalContent = $this->fileObject->getContent();
        $this->fileObject->truncate();

        $this->assertEquals("", $this->fileObject->getContent());
        $this->fileObject->put($originalContent);
    }

    public function testRemove() {
        $originalContent = $this->fileObject->getContent();
        $this->fileObject->remove();
        $filesystem = new Filesystem();

        $this->assertFalse($filesystem->makeAbsolute("tests/filesystem_fixtures/singleFile.txt"));

        $filesystem->touch("tests/filesystem_fixtures", "singleFile.txt");
        $this->fileObject->put($originalContent);

        $this->assertTrue(StringUtils::contains($filesystem->makeAbsolute("tests/filesystem_fixtures/singleFile.txt"), $filesystem->getProjectAbsoluteRoot()));
    }

    public function testMove() {
        $originalContent = $this->fileObject->getContent();

        $filesystem = new Filesystem();
        $this->fileObject->move($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test"));

        $this->assertTrue(StringUtils::contains($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test/singleFile.txt"), $filesystem->getProjectAbsoluteRoot()));

        @unlink($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test/singleFile.txt"));

        $filesystem->touch("tests/filesystem_fixtures", "singleFile.txt");
        $this->fileObject->put($originalContent);

        $this->assertTrue(StringUtils::contains($filesystem->makeAbsolute("tests/filesystem_fixtures/singleFile.txt"), $filesystem->getProjectAbsoluteRoot()));
    }

    public function testCopy() {
        $filesystem = new Filesystem();
        $this->fileObject->copy($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test"));

        $this->assertTrue(StringUtils::contains($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test/singleFile.txt"), $filesystem->getProjectAbsoluteRoot()));

        @unlink($filesystem->makeAbsolute("tests/filesystem_fixtures/move_test/singleFile.txt"));
    }

    public function testItReturnsTheGroupProperly() {
        $groupInfo = $this->fileObject->getGroup();

        if(SystemUtils::getOsType() == SystemUtils::OS_TYPE_NIX) {
            $this->assertInstanceOf(GroupInformation::class, $groupInfo);

            return;
        }

        $this->assertTrue(is_numeric($groupInfo));
    }

    public function testItReturnsTheUserInfoProperly() {
        $userInfo = $this->fileObject->getOwner();

        if(SystemUtils::getOsType() == SystemUtils::OS_TYPE_NIX) {
            $this->assertInstanceOf(UserInformation::class, $userInfo);

            return;
        }

        $this->assertTrue(is_numeric($userInfo));
    }
}