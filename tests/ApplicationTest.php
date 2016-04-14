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
            new Router($this->application)
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
            new Template($this->application)
        );

        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Template',
            $this->application->getTemplate()
        );

        $this->application->getRegistry()->testProperty = "TEST!";
    }

    public function testSetInvalidPath()
    {
        $this->expectException('InvalidArgumentException');
        $this->application->getRouter()->setControllersPath('/controllers');
    }

    /**
     * @group defaultloader
     */
    public function testDefaultLoader()
    {
        ob_start();
        $this->application->getRouter()->loader();
        ob_end_clean();

        $this->assertEquals(
            'Index',
            $this->application->getRouter()->getController()
        );

        $this->assertEquals(
            'index',
            $this->application->getRouter()->getAction()
        );

        $this->assertEquals(
            'Welcome to weblibs-mvc',
            $this->application->getRegistry()->welcome
        );
    }

    public function testExplicitDefaultLoader()
    {
        ob_start();
        $this->application->getRouter()->loader('index');
        ob_end_clean();

        $this->assertEquals(
            'Index',
            $this->application->getRouter()->getController()
        );

        $this->assertEquals(
            'index',
            $this->application->getRouter()->getAction()
        );

        $this->assertEquals(
            'Welcome to weblibs-mvc',
            $this->application->getRegistry()->welcome
        );
    }

    public function testExplicitSampleLoader()
    {
        ob_start();
        $this->application->getRouter()->loader('sample');
        ob_end_clean();

        $this->assertEquals(
            'Sample',
            $this->application->getRouter()->getController()
        );

        $this->assertEquals(
            'index',
            $this->application->getRouter()->getAction()
        );

        $this->assertEquals(
            'This is the sample controller',
            $this->application->getRegistry()->header
        );
    }

    /**
     * @group explicitsample2
     */
    public function testExplicitSampleLoader2()
    {
        ob_start();
        $this->application->getRouter()->loader('sample/index');
        ob_end_clean();

        $this->assertEquals(
            'Sample',
            $this->application->getRouter()->getController()
        );

        $this->assertEquals(
            'index',
            $this->application->getRouter()->getAction()
        );

        $this->assertEquals(
            'This is the sample controller',
            $this->application->getRegistry()->header
        );
    }

}
