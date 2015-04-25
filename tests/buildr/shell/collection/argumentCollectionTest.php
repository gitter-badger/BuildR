<?php namespace buildr\tests\shell\collection; 

use buildr\Shell\Collection\ArgumentCollection;
use buildr\Shell\Value\Argument;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Argument collection tests
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
class argumentCollectionTest extends BuildRTestCase {

    public function testItWorksSimpleArguments() {
        $collection = new ArgumentCollection();

        $collection->addArgument(new Argument('help', 'test'));
        $collection->addArgument(new Argument('d'));

        $this->assertEquals('--help ' . escapeshellarg('test') . ' --d', (string) $collection);
    }

    public function testItWorksWithAdvancedArguments() {
        $collection = new ArgumentCollection();

        $collection->addArgument(new Argument('help', 'test\'r value'));
        $collection->addArgument(new Argument('test_param', 'Árvíztűrő tükörfúrógép'));
        $collection->addArgument(new Argument('d'));

        $this->assertEquals('--help ' . escapeshellarg('test\'r value') . ' --test_param ' . escapeshellarg('Árvíztűrő tükörfúrógép') . ' --d', (string) $collection);
    }

}
