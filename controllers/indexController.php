<?php

use webmvc\application\Controller;

/**
 * Description of indexController
 *
 * @author claudio
 */
class indexController Extends Controller {
    public function index() 
    {
        /** set a template variable */
        $this->registry->template->welcome = 'Welcome to WEBMVC';
        /** load the index template */
        $this->registry->template->show('index');
    }
}
