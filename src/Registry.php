<?php

namespace clagiordano\weblibs\mvc;

/**
 * The registry is an object where site wide variables can be stored without
 * the use of globals.
 * By passing the registry object to the controllers that need them,
 * we avoid pollution of the global namespace and render our variables safe.
 * We need to be able to set registry variables and to get them.
 *
 * @author Claudio Giordano <claudio.giordano@autistici.org>
 */
class Registry
{
    /** @var Controller $controller **/
    private $controller = null;
    /** @var Registry $registry */
    private $registry = null;
    /** @var Router $router **/
    private $router = null;
    /** @var Template $template **/
    private $template = null;

    /**
     * @var array $vars
     */
    private $vars = [];

    /**
     * @return clagiordano\weblibs\mvc\Registry
     */
    public function __constructor()
    {
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
     * @set undefined vars
     *
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * @get variables
     *
     * @param mixed $index
     * @return mixed
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }
}
