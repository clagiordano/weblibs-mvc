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
        $this->application->getTemplate()->heading = "Oops, you've found a dead link.";
        $this->application->getTemplate()->sub_heading = 'Use the links at the top to get back.';

        /** Load the error404 template */
        $this->registry->template->show('error404');
    }
}
