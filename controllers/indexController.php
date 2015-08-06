<?php

use clagiordano\webmvc\application\Controller;

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
        $this->registry->template->welcome = 'Welcome to WEBMVC';
        /** load the index template */
        $this->registry->template->show('index');
    }
}
