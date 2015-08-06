<?php

namespace clagiordano\webmvc\application;

use clagiordano\webmvc\application\Registry;

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
    /**
     * @the registry
     */
    private $registry;

    /**
     * @the controller path
     */
    private $path;
    private $args = array();
    public $file;
    public $controller;
    public $action;

    /**
     *
     * @param Registry $registry
     */
    function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * set controller directory path
     *
     * @param string $path
     * @return void
     */
    function setPath($path)
    {
        /**
         * check if path is a directory
         */
        if (is_dir($path) == false) {
            throw new \Exception('Invalid controller path: `' . $path . '`');
        }

        /**
         * set the path
         */
        $this->path = $path;
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
        $this->getController();

        /**
         * if the file is not there diaf
         */
        if (is_readable($this->file) == false) {
            $this->file       = $this->path . '/error404.php';
            $this->controller = 'error404';
        }

        /**
         * include the controller
         */
        include $this->file;

        /**
         * a new controller class instance
         */
        $class      = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        /**
         * check if the action is callable
         */
        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'index';
        } else {
            $action = $this->action;
        }

        /**
         * run the action and supply optional args to called action
         * as arguments if present.
         */
        $controller->$action($this->args);
    }

    /**
     *
     * get the controller
     *
     * @access private
     * @return void
     */
    private function getController()
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
            $parts            = explode('/', $route);
            $this->controller = $parts[0];
            //~ echo "[Debug]: route: $route <br />";
            //~ echo "[Debug]: controller: {$this->controller} <br />";
            
            // Shift element off the beginning of array
            array_shift($parts);

            if (isset($parts[0])) {
                $this->action = $parts[0];
                //~ echo "[Debug]: action: {$this->action} <br />";

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
            $this->controller = 'index';
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
        $this->file = $this->path . '/' . $this->controller . 'Controller.php';
    }

    /**
     * Parse optional args after the action.
     *
     * @param array $argsList array with residual route args
     */
    private function parseArgs($argsList = [])
    {
        /**
         * Check last args and unset if empty
         */
        if (trim($argsList[count($argsList) - 1]) == "") {
            // Invalid arg detected and removed
            unset($argsList[count($argsList) - 1]);
        }
         
        if ((count($argsList) % 2) == 0) {
            /**
             * if the arguments are odd, I consider them as key => value pairs
             */
            for ($i = 0; $i < count($argsList); $i++) {
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
