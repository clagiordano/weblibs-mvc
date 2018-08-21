<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Application;
//use clagiordano\weblibs\mvc\Router;
use clagiordano\weblibs\configmanager\ConfigManager;
use clagiordano\weblibs\mvc\Container;
use stdClass;

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
        self::assertInstanceOf(
            'clagiordano\weblibs\mvc\Application',
            $this->application
        );

        /**
         * Create and sets the router
         * TODO: need refactor
         */
//        $this->application->getContainer()
//            ->set('router', new Router($this->application));
//
//
//        self::assertInstanceOf(
//            'clagiordano\weblibs\mvc\Router',
//            $this->application->getContainer()->get('router')
//        );
//
        /**
         * set the path to the controllers directory
         * TODO: need refactor
         */
//        $this->application->getRouter()->setControllersPath(
//            __DIR__ . '/../controllers'
//        );
//
//        self::assertInstanceOf(
//            'clagiordano\weblibs\mvc\Template',
//            $this->application->getTemplate()
//        );
//
//        $this->application->getRegistry()->testProperty = "TEST!";
    }

    /**
     * @test
     */
    public function canGetConfigurationInstanceFromApp()
    {
        self::assertInstanceOf(
            'clagiordano\weblibs\configmanager\ConfigManager',
            $this->application->getConfig()
        );
    }

    /**
     * @test
     */
    public function canSetConfigurationInstanceToApp()
    {
        $config = new ConfigManager();
        $config->setValue('test', 'value');

        $this->application->setConfig($config);

        self::assertInstanceOf(
            'clagiordano\weblibs\configmanager\ConfigManager',
            $this->application->getConfig()
        );

        self::assertSame(
            $config,
            $this->application->getConfig()
        );
    }

    /**
     * @test
     */
    public function canGetContainerInstanceFromApp()
    {
        self::assertInstanceOf(
            'clagiordano\weblibs\mvc\Container',
            $this->application->getContainer()
        );
    }

    /**
     * @test
     */
    public function canSetContainerInstanceToApp()
    {
        $container = new Container();
        $container->set('sampleService', new stdClass());

        $this->application->setContainer($container);

        self::assertInstanceOf(
            'clagiordano\weblibs\mvc\Container',
            $this->application->getContainer()
        );

        self::assertSame(
            $container,
            $this->application->getContainer()
        );
    }

    public function testSetInvalidPath()
    {
        $this->markTestIncomplete();
        $this->setExpectedException('InvalidArgumentException');
        $this->application->getRouter()->setControllersPath('/controllers');
    }

    /**
     * @group defaultloader
     */
    public function testDefaultLoader()
    {
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

        ob_start();
        $this->application->getRouter()->loader('invalid');
        ob_end_clean();
    }

    public function testInvalidAction()
    {
        $this->markTestIncomplete();

        $this->application->getRouter()->loader('sample/invalid');
    }

    public function testParseRoute()
    {
        $this->markTestIncomplete();

        $this->application->getRouter()->loader('sample/index/aaa/bbb');
    }

    public function testParseRoute2()
    {
        $this->markTestIncomplete();

        $this->application->getRouter()->loader('sample/index/aaa/bbb/');
    }

    /**
     * @group testarguments
     */
    public function testGetArguments()
    {
        $this->markTestIncomplete();

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
        $this->markTestIncomplete();

        ob_start();
        $this->application->getRouter()->loader(
            'sample/testparams?type=1&category=3&show=0,20'
        );
        $out = ob_get_clean();

        $this->assertEquals(
            '[{"type":"1","category":"3","show":"0,20"}]',
            $out
        );
    }

    /**
     * @group testparams
     */
    public function testGetParams2()
    {
        $this->markTestIncomplete();

        ob_start();
        $this->application->getRouter()->loader(
            'sample/testparams/test?type=1&category=3&show=0,20'
        );
        $out = ob_get_clean();
        
        $this->assertEquals(
            '["test",{"type":"1","category":"3","show":"0,20"}]',
            $out
        );
    }
}
