<?php namespace buildr\tests\shell\collection; 

use buildr\Shell\Collection\ParameterCollection;
use buildr\Shell\Value\Parameter;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Parameter collection test
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
class parameterCollectionTest extends BuildRTestCase {

    public function testItWorksCorrectly() {
        $collection = new ParameterCollection();

        $collection->addParameter(new Parameter('Árvíztűrő tükörfúrógép'));
        $collection->addParameter(new Parameter('Quote\'d value`s'));

        $this->assertEquals(escapeshellarg('Árvíztűrő tükörfúrógép') . ' ' . escapeshellarg('Quote\'d value`s'), (string) $collection);
    }

}
