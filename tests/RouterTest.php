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
    private $router = null;
    private $registry = null;

    public function setUp()
    {
        /*$this->registry = new Registry();
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Registry',
            $this->registry
        );

        $this->router = new Router($this->registry);
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Router',
            $this->router
        );

        $this->router->setPath(__DIR__ . '/../controllers');

        $this->template = new Template($this->registry);*/

        /**
         * Create a new registry object
         **/
        $registry = new Registry();

        /**
         * load the router
         */
        $registry->router = new Router($registry);

        /**
         * set the path to the controllers directory
         */
        $registry->router->setPath(__DIR__ . '/../controllers');

        /**
         * load up the template
         */
        $registry->template = new Template($registry);

        /**
         * load the controller
         */
        $registry->router->loader();
    }

    public function testSetInvalidPath()
    {
        $this->expectException('InvalidArgumentException');
        $this->router->setPath('/controllers');
    }

    public function testLoader()
    {
        $this->registry->router->loader();
    }
}
