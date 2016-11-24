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
    /**
     * @const string CONTROLLER_CLASS_SUFFIX suffix string for controller file
     */
    const CONTROLLER_CLASS_SUFFIX = 'Controller';
    /**
     * @const string ROUTING_GET_KEY array key to get for route calculation
     */
    const ROUTING_GET_KEY = 'rt';

    /** @var Application $application */
    protected $application;
    /** @var string $path controller path */
    protected $controllersPath;
    /** @var array $controllerActionArgs */
    protected $controllerActionArgs = [];
    /** @var string $controllerFile */
    protected $controllerFile;
    /** @var string $controller */
    protected $controller;
    /** @var string $controllerAction */
    protected $controllerAction;
    /** @var mixed $controllerClass controller class instance */
    protected $controllerClass = null;
    /** @var string $querystring */
    protected $querystring = null;

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
                self::ROUTING_GET_KEY
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
         * Autoload and create a new controller class instance
         */
        $class = ucfirst($this->controller . self::CONTROLLER_CLASS_SUFFIX);
        $this->autoloadController($class);
        $this->controllerClass = new $class($this->application);

        /**
         * check if the action is callable
         */
        if (is_callable([$this->controllerClass, $this->controllerAction]) === false) {
            $this->controllerAction = 'index';
        }

        return $this->callControllerAction();
    }

    /**
     * run the action and supply optional args to called action
     * as arguments if present.
     */
    private function callControllerAction()
    {
        if (!$this->controllerActionArgs) {
            return call_user_func(
                [
                    $this->controllerClass,
                    $this->controllerAction
                ]
            );
        }
        
        return call_user_func_array(
            [
                $this->controllerClass,
                $this->controllerAction
            ],
            $this->controllerActionArgs
        );
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
        $routeComponents = parse_url($route);
        if (isset($routeComponents['query'])) {
            $this->querystring = $routeComponents['query'];
        }

        if (isset($routeComponents['path'])
            && (strpos($routeComponents['path'], '/') > 0)) {
            $routeParts = explode('/', $routeComponents['path']);
            $this->controller = ucfirst($routeParts[0]);

            /**
             * Shift element off the beginning of array
             */
            array_shift($routeParts);
            $this->controllerAction = $routeParts[0];

            /**
             * Shift element off the beginning of array
             */
            array_shift($routeParts);

            /**
             * Get optional residual args
             */
            if (count($routeParts) > 0) {
                $this->parseRoutePath($routeParts);
            }
        }

        $this->parseQueryString();

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
    private function parseRoutePath($argsList = [])
    {
        $argsListCount = count($argsList);

        /**
         * Check last args and unset if empty
         */
        if (trim($argsList[$argsListCount - 1]) == "") {
            /**
             * Invalid argument detected and removed
             */
            unset($argsList[$argsListCount - 1]);
        }

        /**
         * All residual args will be prepared for use as action argument
         */
         $this->controllerActionArgs = $argsList;
    }

    /**
     * Parse query string parameters and append as associative array to
     * controller action arguments
     */
    private function parseQueryString()
    {
        $queryParams = [];

        /**
         * Drop useless routing part
         */
        $route = filter_input(INPUT_GET, self::ROUTING_GET_KEY);
        if ($route) {
            unset($_GET[self::ROUTING_GET_KEY]);
        }

        if (count($_GET) > 0) {
            $queryParams = $_GET;
        } elseif (isset($this->querystring)) {
            $params = explode('&', $this->querystring);
            foreach ($params as $param) {
                list($key, $value) = explode('=', $param);
                $queryParams[$key] = $value;
            }
        }

        /**
         * Prepare additional arguments
         */
        foreach ($queryParams as $key => $value) {
            $this->controllerActionArgs['filters'][$key] = $value;
        }
    }

    /**
     * Load class file from disk and check for class existence
     *
     * @param string $controllerClass
     */
    public function autoloadController($controllerClass)
    {
        if ($controllerClass) {
            $classFilePath = "{$this->getControllersPath()}/{$controllerClass}.php";

            /**
             * If class file exists and class not loaded, load file from disk
             */
            if (file_exists($classFilePath) && !class_exists($controllerClass)) {
                require_once $classFilePath;

                if (!class_exists($controllerClass)) {
                    throw new \RuntimeException(
                        __METHOD__ . ": Failed autoload for class '{$controllerClass}'!"
                    );
                }
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
