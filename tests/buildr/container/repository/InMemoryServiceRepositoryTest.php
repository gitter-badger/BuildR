<?php namespace buildr\tests\container\repository;

use buildr\Container\Repository\InMemoryServiceRepository;

/**
 * 
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Container\Repository
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class InMemoryServiceRepositoryTest extends AbstractServiceRepositoryTest {

    /**
     * @return \buildr\Container\Repository\ServiceRepositoryInterface
     */
    public function setupRepository() {
        return new InMemoryServiceRepository();
    }

}
