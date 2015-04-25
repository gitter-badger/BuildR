<?php namespace buildr\Shell;

use buildr\Shell\Collection\ArgumentCollection;
use buildr\Shell\Collection\FlagCollection;
use buildr\Shell\Collection\ParameterCollection;
use buildr\Shell\Value\Argument;
use buildr\Shell\Value\Flag;
use buildr\Shell\Value\Parameter;
use buildr\Shell\Value\SubCommand;

/**
 * Shell command builder
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Command implements CommandInterface {

    /**
     * @type \buildr\Shell\Collection\ArgumentCollection
     */
    private $argumentCollection;

    /**
     * @type \buildr\Shell\Collection\FlagCollection
     */
    private $flagCollection;

    /**
     * @type \buildr\Shell\Collection\ParameterCollection
     */
    private $parameterCollection;

    /**
     * @type \buildr\Shell\Value\SubCommand
     */
    private $subCommand;

    /**
     * @type string
     */
    private $mainCommand;

    public function __construct($command) {
        if($command === NULL) {
            throw new \InvalidArgumentException("The command cannot be NULL!");
        }

        $this->mainCommand = $command;

        $this->argumentCollection = new ArgumentCollection();
        $this->flagCollection = new FlagCollection();
        $this->parameterCollection = new ParameterCollection();
    }

    /**
     * Push a new argument to the argument collection
     *
     * @param \buildr\Shell\Value\Argument $argument
     *
     * @return \buildr\Shell\Command
     */
    public function addArgument(Argument $argument) {
        $this->argumentCollection->addArgument($argument);

        return $this;
    }

    /**
     * Push a new flag to the flag collection
     *
     * @param \buildr\Shell\Value\Flag $flag
     *
     * @return \buildr\Shell\Command
     */
    public function addFlag(Flag $flag) {
        $this->flagCollection->addFlag($flag);

        return $this;
    }

    /**
     * Push a new parameter to the parameter collection
     *
     * @param \buildr\Shell\Value\Parameter $parameter
     *
     * @return \buildr\Shell\Command
     */
    public function addParameter(Parameter $parameter) {
        $this->parameterCollection = $parameter;

        return $this;
    }

    /**
     * Set the currently used sub command
     *
     * @param \buildr\Shell\Value\SubCommand $subCommand
     *
     * @return \buildr\Shell\Command
     */
    public function addSubCommand(SubCommand $subCommand) {
        $this->subCommand = $subCommand;

        return $this;
    }

    public function __toString() {
        return sprintf("%s %s %s %s %s", $this->mainCommand, $this->subCommand, $this->argumentCollection, $this->flagCollection, $this->parameterCollection);
    }

}
