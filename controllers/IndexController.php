<?php

use clagiordano\weblibs\mvc\Controller;

/**
 * Sample default IndexController
 */
class IndexController extends Controller
{
    public function index()
    {
        /** set a template variable */
        $this->application->getRegistry()->welcome = 'Welcome to weblibs-mvc';
        /** load the index template */
        $this->application->getTemplate()->show('index');
    }
}
