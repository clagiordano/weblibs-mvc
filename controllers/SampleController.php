<?php

use clagiordano\weblibs\mvc\Controller;

/**
 * Sample default IndexController
 */
class SampleController extends Controller
{
    /**
     * All controllers must implements an index method
     */
    public function index()
    {
        /** set a template variable */
        $this->application->getRegistry()->header = 'This is the sample controller';
        /** load the index template */
        $this->application->getTemplate()->show('sample');
    }

    public function test()
    {
        echo json_encode(func_get_args());
    }

    public function testargs($foo, $bar, $baz)
    {
        echo "Foo: $foo\n";
        echo json_encode(func_get_args());
    }
}
