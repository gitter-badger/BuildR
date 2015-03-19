<?php namespace buildr\Config\Facade;

use buildr\Facade\Facade;

/**
 * BuildR - PHP based continuous integration server
 *
 * Configuration facade
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @method static mixed getFromMainSource(string $selector, mixed $defaultValue = NULL) Get the configuration value from the main config source (Default: File)
 * @method static mixed getFormAnySource(string $selector, mixed $defaultValue = NULL) Try to get configuration value from any configuration source. Sources ordered by its priority.
 * @method static mixed getFromSource(string $sourceName, string $selector, mixed $defaultValue = NULL) Get a configuration value from a pre-defined sourceű
 * @method static void addSource(\buildr\Config\Source\ConfigSourceInterface $source, int $priority) Push a new configuration source to the source stack
 * @method static \buildr\Config\Source\ConfigSourceInterface getSourceByPriority(int $priority) Return a configuration source by priority
 * @method static \buildr\Config\Source\ConfigSourceInterface getSourceByName(string $name) Return a configuration source by its name
 */
class Config extends Facade {

    public function getBindingName() {
        return 'config';
    }
}
