<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Request;

/**
 * Class MapperTest
 * @package clagiordano\weblibs\dbabstraction\tests
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var Request $registry */
    private $request = null;

    public function setUp()
    {
        $this->request = new Request();

        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Request',
            $this->request
        );
    }

    /**
     * @group settype
     * @return
     */
    public function testSetType()
    {
        $this->expectException('\InvalidArgumentException');
        $this->request->setType("InvalidType");
    }

    /**
     * @group gettype
     * @return
     */
    public function testGetType()
    {
        $this->request->setType("GET");

        $this->assertEquals("GET", $this->request->getType());
    }

    /**
     * @group getdata
     * @return
     */
    public function testGetData()
    {
        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }

    /**
     * @group putrequest
     * @return
     */
    public function testPutRequest()
    {
        $this->request->setType('PUT');

        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            $testData,
            $this->request->getData()
        );
    }

    /**
     * @group postrequest
     * @return
     */
    public function testPostRequest()
    {
        $this->request->setType('POST');

        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            $testData,
            $this->request->getData()
        );
    }

    /**
     * @group getrequest
     * @return
     */
    public function testGetRequest()
    {
        $this->request->setType('GET');

        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }

    /**
     * @group deleterequest
     * @return
     */
    public function testDeleteRequest()
    {
        $this->request->setType('DELETE');

        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }

    /**
     * @group headrequest
     * @return
     */
    public function testHeadRequest()
    {
        $this->request->setType('HEAD');

        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }

    /**
     * @group dynamicrequest
     * @return
     */
    public function testDynamicRequest()
    {
        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }

    /**
     * @group invalidrequest
     * @return
     */
    public function testInvalidRequest()
    {
        /**
         * Normal request setup with data
         */
        $testData = ['test' => 'value'];

        $this->request->setData(
            json_encode($testData)
        );

        /**
         * Force by reflection internal property to test throw
         */
        $class = new \ReflectionClass($this->request);
        $property = $class->getProperty('requestType');
        $property->setAccessible(true);
        $property->setValue($this->request, "INVALIDREQUEST");

        /**
         * Now we expect exception!
         */
         $this->expectException('InvalidArgumentException');

        $this->assertEquals(
            null,
            $this->request->getData()
        );
    }
}
