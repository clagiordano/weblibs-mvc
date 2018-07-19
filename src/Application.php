<?php

namespace clagiordano\weblibs\mvc;

/**
 * This is the main application class which handle other components.
 */
class Application
{
    /** @var Registry $registry */
    private $registry = null;
    /** @var Router $router **/
    private $router = null;
    /** @var Template $template **/
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
