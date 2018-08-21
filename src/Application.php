<?php

namespace clagiordano\weblibs\mvc;

use clagiordano\weblibs\configmanager\ConfigManager;

/**
 * Class Application, This is the main application class which handle other components.
 * @package clagiordano\weblibs\mvc
 */
class Application
{
    /** @var ConfigManager $config */
    protected $config = null;
    /** @var Container $container */
    protected $container = null;

    /**
     * Application constructor.
     * @param ConfigManager|null $config
     * @param Container|null $container
     */
    public function __construct(ConfigManager $config = null, Container $container = null)
    {
        $this->setConfig($config);
        $this->setContainer($container);
    }

    /**
     * @return ConfigManager
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ConfigManager $config
     * @return Application
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return Application
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }
}
