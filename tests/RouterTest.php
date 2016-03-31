<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Registry;
use clagiordano\weblibs\mvc\Router;
use clagiordano\weblibs\mvc\Template;

/**
 * Class MapperTest
 * @package clagiordano\weblibs\dbabstraction\tests
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /** @var Registry $registry */
    private $registry = null;

    public function setUp()
    {
        /**
         * Create a new registry object
         **/
        $this->registry = new Registry();
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Registry',
            $this->registry
        );

        /**
         * load the router
         */
        $this->registry->router = new Router($this->registry);
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Router',
            $this->registry->router
        );

        /**
         * set the path to the controllers directory
         */
        $this->registry->router->setControllersPath(__DIR__ . '/../controllers');

        /**
         * load up the template
         */
        $this->registry->template = new Template($this->registry);
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Template',
            $this->registry->template
        );

        /**
         * load the controller
         */
        $this->registry->router->loader();
    }

    public function testSetInvalidPath()
    {
        $this->expectException('InvalidArgumentException');
        $this->registry->router->setControllersPath('/controllers');
    }

    public function testLoader()
    {
        $this->registry->router->loader();
    }
}
