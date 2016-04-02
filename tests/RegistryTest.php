<?php

namespace clagiordano\weblibs\mvc\tests;

use clagiordano\weblibs\mvc\Registry;

/**
 * Class MapperTest
 * @package clagiordano\weblibs\dbabstraction\tests
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    private $registry = null;

    public function setUp()
    {
        $this->registry = new Registry();
        $this->assertInstanceOf(
            'clagiordano\weblibs\mvc\Registry',
            $this->registry
        );
    }

    public function testGetSetProperty()
    {
        $testValue = "Test";
        $this->registry->test = $testValue;

        $this->assertEquals(
            $testValue,
            $this->registry->test
        );
    }

}
