<?php

namespace clagiordano\weblibs\mvc;

/**
 * The router class is responsible for loading up the correct controller.
 * It does nothing else. The value of the controller comes from the URL.
 *
 * Dynamic routing object
 *
 * @author Claudio Giordano <claudio.giordano@autistici.org>
 */
class Router
{
    /** @var Application $application */
    protected $application;
    /** @var string $path controller path */
    private $controllersPath;
    /** @var array $args */
    private $args = [];
    /** @var string $controllerFile */
    public $controllerFile;
    /** @var string $controller */
    public $controller;
    /** @var string $controllerAction */
    public $controllerAction;

    /**
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $registerStatus = spl_autoload_register([$this, 'autoloadController']);

        if (!$registerStatus) {
            throw new \RuntimeException(
                __METHOD__ . ": Failed spl_autoload_register!"
            );
        }

        $this->application = $application;
    }

    /**
     * set the controller directory path
     *
     * @param string $controllersPath
     * @return void
     */
    public function setControllersPath($controllersPath)
    {
        /**
         * check if path is a directory
         */
        if (is_dir($controllersPath) === false) {
            throw new \InvalidArgumentException(
                __METHOD__ . ": Invalid controller path: '{$controllersPath}'"
            );
        }

        /**
         * set the path
         */
        $this->controllersPath = $controllersPath;
    }

    /**
     * Returns the controller directory path
     *
     * @return string
     */
    public function getControllersPath()
    {
        return $this->controllersPath;
    }

    /**
     * Load the controller and perform call action
     */
    public function loader($route = null)
    {
        /**
         * get the route from the url
         */
        if (is_null($route)) {
            $route = filter_input(
                INPUT_GET,
                'rt',
                FILTER_SANITIZE_URL,
                [
                    'default' => 'index'
                ]
            );
        }

        $this->parseRoute($route);

        /**
         * if the file is not there diaf
         */
        if (is_readable($this->controllerFile) === false) {
            $this->controllerFile = $this->getControllersPath() . '/Error404.php';
            $this->controller = 'Error404';
        }

        /**
         * a new controller class instance
         */
        $class = ucfirst($this->controller . 'Controller');
        $controller = new $class($this->application);

        /**
         * check if the action is callable
         */
        $action = $this->controllerAction;
        if (is_callable([$controller, $this->controllerAction]) === false) {
            $action = 'index';
        }

        /**
         * run the action and supply optional args to called action
         * as arguments if present.
         */
        $controller->$action($this->args);
    }

    /**
     * Sets internal property file with the correct controller path.
     *
     * @access private
     * @return void
     */
    private function parseRoute($route = 'index')
    {
        if (is_null($route) || $route === false) {
            $route = 'index';
        }

        /**
         * Sets the default controller
         */
        $this->controller = ucfirst($route);

        /**
         * Sets the default action
         */
        $this->controllerAction = 'index';

        /**
         * Check for multi part route
         */
        if (strpos($route, '/') > 0) {
            $parts = explode('/', $route);

            $this->controller = ucfirst($parts[0]);

            // Shift element off the beginning of array
            array_shift($parts);

            $this->controllerAction = $parts[0];

            // Shift element off the beginning of array
            array_shift($parts);

            /**
             * Get optional residual args
             */
            if (count($parts) > 0) {
                $this->parseArgs($parts);
            }
        }

        /**
         * set the file path
         */
        $this->controllerFile = $this->getControllersPath() . '/';
        $this->controllerFile .= $this->controller . 'Controller.php';
    }

    /**
     * Parse optional args after the action.
     *
     * @param array $argsList array with residual route args
     */
    private function parseArgs($argsList = [])
    {
        $argsListCount = count($argsList);
        /**
         * Check last args and unset if empty
         */
        if (trim($argsList[$argsListCount - 1]) == "") {
            // Invalid argument detected and removed
            unset($argsList[$argsListCount - 1]);
        }

        if (($argsListCount % 2) != 0) {
            /**
             * I consider them as arguments list
             */
            $this->args = $argsList;

            return;
        }

        /**
         * if the arguments are odd, I consider them as key => value pairs
         */
        for ($i = 0; $i < $argsListCount; $i++) {
            $this->args[$argsList[$i]] = $argsList[($i + 1)];
            $i++;
        }
    }

    /**
     *
     * @param string $controllerClass
     */
    public function autoloadController($controllerClass)
    {
        if ($controllerClass) {
            set_include_path($this->getControllersPath());
            spl_autoload($controllerClass);

            $classPath = $this->getControllersPath() . "/" .  $controllerClass . ".php";
            if (!file_exists($classPath)) {
                throw new \InvalidArgumentException(
                    __METHOD__ . ": Invalid class path '{$classPath}'!"
                );
            }

            require_once $classPath;

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException(
                    __METHOD__ . ": Failed autoload for class '{$controllerClass}'!"
                );
            }
        }
    }

    /**
     * Returns selected controller base name
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns selected controller action name
     */
    public function getAction()
    {
        return $this->controllerAction;
    }
}
