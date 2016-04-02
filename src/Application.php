<?php

namespace clagiordano\weblibs\mvc;

use clagiordano\weblibs\mvc\Controller;
use clagiordano\weblibs\mvc\Registry;
use clagiordano\weblibs\mvc\Router;
use clagiordano\weblibs\mvc\Template;

/**
 *
 */
class Application
{
    /** Controller $controller **/
    private $controller = null;
    /** Registry $registry */
    private $registry = null;
    /** Router $router **/
    private $router = null;
    /** Template $template **/
    private $template = null;

    /**
     * @return \clagiordano\weblibs\mvc\Application
     */
    public function __construct()
    {
        $this->setRegistry(new Registry());

        return $this;
    }

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

    /**
     * @param Registry $registry
     * @return \clagiordano\weblibs\mvc\Application
     */
    public function setRegistry(Registry $registry)
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * @return \clagiordano\weblibs\mvc\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }
}
