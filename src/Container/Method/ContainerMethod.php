<?php namespace buildr\Container\Method;

use buildr\Utils\Enum\BaseEnumeration;

class ContainerMethod extends BaseEnumeration {

    const CLOSURE = 'closure';

    const INSTANCE = 'instance';

    const BIND = 'bind';

    const WIRE = 'wire';

}
