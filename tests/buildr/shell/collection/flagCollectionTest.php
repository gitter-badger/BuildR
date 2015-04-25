<?php namespace buildr\tests\shell\collection; 

use buildr\Shell\Collection\FlagCollection;
use buildr\Shell\Value\Flag;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Flag collection tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Shell\Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class flagCollectionTest extends BuildRTestCase {

    public function testItWorksWithSimpleValue() {
        $collection = new FlagCollection();

        $collection->addFlag(new Flag('d'));
        $collection->addFlag(new Flag('c', 'file.php'));

        $this->assertEquals('-d -c ' . escapeshellarg('file.php'), (string) $collection);
    }

    public function testItWorksWithAdvancedValues() {
        $collection = new FlagCollection();

        $collection->addFlag(new Flag('c', '/home/user/asd.php'));
        $collection->addFlag(new Flag('user', 'Zoltán Borsos'));

        $this->assertEquals('-c ' . escapeshellarg('/home/user/asd.php') . ' -user ' . escapeshellarg('Zoltán Borsos'), (string) $collection);
    }

}
