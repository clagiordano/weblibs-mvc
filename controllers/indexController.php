<?php

use clagiordano\weblibs\mvc\Controller;

/**
 * Description of indexController
 *
 * @author claudio
 */
class indexController extends Controller
{
    public function index()
    {
        /** set a template variable */
        $this->application->getRegistry()->welcome = 'Welcome to weblibs-mvc';
        /** load the index template */
        $this->application->getTemplate()->show('index');
    }
}
