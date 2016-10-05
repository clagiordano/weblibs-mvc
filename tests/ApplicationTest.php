<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Application;
use clagiordano\weblibs\mvc\Registry;
use clagiordano\weblibs\mvc\Router;
use clagiordano\weblibs\mvc\Template;

/**
 * Class ApplicationTest
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
        $this->setExpectedException('InvalidArgumentException');
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

    public function testInvalidController()
    {
        ob_start();
        $this->application->getRouter()->loader('invalid');
        ob_end_clean();
    }

    public function testInvalidAction()
    {
        $this->application->getRouter()->loader('sample/invalid');
    }

    public function testParseRoute()
    {
        $this->application->getRouter()->loader('sample/index/aaa/bbb');
    }

    public function testParseRoute2()
    {
        $this->application->getRouter()->loader('sample/index/aaa/bbb/');
    }

    /**
     * @group testarguments
     */
    public function testGetArguments()
    {
        $this->application->getRouter()->loader();

        ob_start();
        $this->application->getRouter()->loader('sample/test/aaa');
        echo "\n";

        $this->application->getRouter()->loader('sample/test/aaa/bbb');
        echo "\n";

        $this->application->getRouter()->loader('sample/test/aaa/bbb/ccc');
        echo "\n";

        $this->application->getRouter()->loader('sample/test/aaa/bbb/ccc?ddd=eee');
        echo "\n";

        $this->application->getRouter()->loader('sample/test/aaa/bbb/ccc/?ddd=eee');
        echo "\n";

        $this->application->getRouter()->loader('sample/testargs/aaa/bbb/ccc/?ddd=eee');
        echo "\n";

        $out = ob_get_clean();
        // old output = [["aaa","bbb","ccc"]]
        // new output = ["aaa","bbb","ccc"]

        //var_dump($out);
    }

    /**
     * @group testparams
     */
    public function testGetParams()
    {
        // api/getProducts/type/1/category/3/show/0,20
        $this->application->getRouter()->loader(
            'sample/testparams/pippo/?type=1&category=3&show=0,20'
        );
    }
}
