<?php

use clagiordano\webmvc\application\Controller;

class error404Controller Extends Controller {

    public function index()
    {
        $this->registry->template->heading     = "Oops, you've found a dead link.";
        $this->registry->template->sub_heading = "Use the links at the top to get back.";
        $this->registry->template->show('error404');
    }
}
