<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Application;
use clagiordano\weblibs\mvc\Registry;
use clagiordano\weblibs\mvc\Router;
use clagiordano\weblibs\mvc\Template;

/**
 * Class MapperTest
 * @package clagiordano\weblibs\dbabstraction\tests
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application $application */
    private $application = null;

    public function setUp()
    {
        /**
         * Create a new application object
         **/
        $this->application = new Application();
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Application',
            $this->application
        );

        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Registry',
            $this->application->getRegistry()
        );

        /**
         * Create and sets the router
         */
        $this->application->setRouter(
            new Router($this->application->getRegistry())
        );


        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Router',
            $this->application->getRouter()
        );

        /**
         * set the path to the controllers directory
         */
        $this->application->getRouter()->setControllersPath(
            __DIR__ . '/../controllers'
        );

        /**
         * load up the template
         */
        $this->application->setTemplate(
            new Template($this->application->getRegistry())
        );

        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Template',
            $this->application->getTemplate()
        );

        $this->application->getRegistry()->testProperty = "TEST!";

        /**
         * load the controller
         */
        $this->application->getRouter()->loader();
    }

    public function testSetInvalidPath()
    {
        $this->expectException('InvalidArgumentException');
        $this->application->getRouter()->setControllersPath('/controllers');
    }

    public function testLoader()
    {
        $this->application->getRouter()->loader();
    }
}
