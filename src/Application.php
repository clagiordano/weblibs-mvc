<?php

namespace clagiordano\weblibs\mvc;

use Controller;
use Router;
use Template;

/**
 *
 */
class Application
{
    /** Controller $controller **/
    private $controller = null;
    /** Router $router **/
    private $router = null;
    /** Template $template **/
    private $template = null;

    /**
     * @param Controller $controller
     * @return \clagiordano\weblibs\mvc\Application
     */
    public function setController(Controller $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * @return \clagiordano\weblibs\mvc\Router
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param Router $router
     * @return \clagiordano\weblibs\mvc\Application
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @return \clagiordano\weblibs\mvc\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Template $template
     * @return \clagiordano\weblibs\mvc\Application
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return \clagiordano\weblibs\mvc\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
