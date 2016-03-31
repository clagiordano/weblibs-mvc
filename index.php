<?php

/**
 * define the site path constant
 */
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

$URI  = filter_input(INPUT_SERVER, 'REQUEST_SCHEME') . "://";
$URI .= filter_input(INPUT_SERVER, 'HTTP_HOST');
$URI .= dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME')) . "/";
define ('__SITE_WEB_PATH', $URI);

/**
 * include the init.php file
 */
include 'includes/init.php';

use clagiordano\weblibs\webmvc\Registry;
use clagiordano\weblibs\webmvc\Router;
use clagiordano\weblibs\webmvc\Template;

/**
 * Create a new registry object
 **/
$registry = new Registry();

/**
 * load the router
 */
$registry->router = new Router($registry);

/**
 * set the path to the controllers directory
 */
$registry->router->setPath(__SITE_PATH . '/controllers');

/**
 * load up the template
 */
$registry->template = new Template($registry);

/**
 * load the controller
 */
$registry->router->loader();
