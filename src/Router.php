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
    private $args = [];
    public $controllerFile;
    public $controller;
    public $action;

    /**
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
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
     * load the controller
     *
     * @access public
     * @return void
     */
    public function loader()
    {
        /**
         * check the route
         */
        $this->getCurrentController();

        /**
         * if the file is not there diaf
         */
        if (is_readable($this->controllerFile) === false) {
            $this->controllerFile = $this->getControllersPath() . '/error404.php';
            $this->controller = 'Error404';
        }

        /**
         * include the controller
         */
        include_once $this->controllerFile;

        /**
         * a new controller class instance
         */
        $class = $this->controller . 'Controller';
        $controller = new $class($this->application);

        /**
         * check if the action is callable
         */
        $action = $this->action;
        if (is_callable([$controller, $this->action]) === false) {
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
    private function getCurrentController()
    {
        /**
         * get the route from the url
         */
        $route = filter_input(INPUT_GET, 'rt', FILTER_SANITIZE_URL);

        if (empty($route)) {
            $route = 'index';
        } else {
            /**
             * get the parts of the route
             */
            $parts = explode('/', $route);
            $this->controller = $parts[0];

            // Shift element off the beginning of array
            array_shift($parts);

            if (isset($parts[0])) {
                $this->action = $parts[0];

                // Shift element off the beginning of array
                array_shift($parts);
            }

            /**
             * Get optional residual args
             */
            if (count($parts) > 0) {
                $this->parseArgs($parts);
            }
        }

        if (empty($this->controller)) {
            $this->controller = 'Index';
        }

        /**
         * Get action
         */
        if (empty($this->action)) {
            $this->action = 'index';
        }

        /**
         * set the file path
         */
        $this->controllerFile = $this->getControllersPath() . '/' . $this->controller . 'Controller.php';
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
            // Invalid arg detected and removed
            unset($argsList[$argsListCount - 1]);
        }

        if (($argsListCount % 2) == 0) {
            /**
             * if the arguments are odd, I consider them as key => value pairs
             */
            for ($i = 0; $i < $argsListCount; $i++) {
                $this->args[$argsList[$i]] = $argsList[($i + 1)];
                $i++;
            }
        } else {
            /**
             * else I consider them as arguments list
             */
            $this->args = $argsList;
        }
    }
}
