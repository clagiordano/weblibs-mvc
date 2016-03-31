<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Registry;
use clagiordano\weblibs\mvc\Router;

/**
 * Class MapperTest
 * @package clagiordano\weblibs\dbabstraction\tests
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $router = null;
    private $registry = null;

    public function setUp()
    {
        $this->registry = new Registry();
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Registry',
            $this->registry
        );

        $this->router = new Router($this->registry);
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Router',
            $this->router
        );
    }

    public function testUsage()
    {

    }
}
