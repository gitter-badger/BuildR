<?php namespace buildr\tests\shell;

use buildr\Shell\Command;
use buildr\Shell\Value\Argument;
use buildr\Shell\Value\Flag;
use buildr\Shell\Value\Parameter;
use buildr\Shell\Value\SubCommand;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Command test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Shell
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */

class commandTest extends BuildRTestCase {

    public function testItWorksCorrectly() {
        $command = new Command('phpunit');

        $command->addArgument(new Argument('configuration', './build/phpunit-ci.xml'))
            ->addParameter(new Parameter('./src/*.php'))
            ->addFlag(new Flag('d'));

        $this->assertEquals('phpunit --configuration ' . escapeshellarg('./build/phpunit-ci.xml') . ' -d ' . escapeshellarg('./src/*.php'), (string) $command);
    }

    public function testItWorksWithSubCommand() {
        $command = new Command('apigen');

        $command->addArgument(new Argument('tree'))
            ->addArgument(new Argument('todo'))
            ->addFlag(new Flag('c'))
            ->addParameter(new Parameter('./src/*.php'))
            ->addSubCommand(new SubCommand('generate'));

        $this->assertEquals('apigen generate --tree --todo -c ' . escapeshellarg('./src/*.php'), (string) $command);
    }

}
