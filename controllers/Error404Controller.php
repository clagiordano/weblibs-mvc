<?php

use clagiordano\weblibs\mvc\Controller;

/**
 * Sample default Error404Controller
 */
class Error404Controller extends Controller
{
    /**
     * All controllers must implements an index method
     */
    public function index()
    {
        /** Sets template variables */
        $this->application->getRegistry()->heading = "Oops, you've found a dead link.";
        $this->application->getRegistry()->sub_heading = 'Use the links at the top to get back.';

        /** Load the error404 template */
        $this->application->getTemplate()->show('error404');
    }
}
