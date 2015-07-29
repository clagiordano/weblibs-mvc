<?php

namespace clagiordano\webmvc;

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * define the site path constant
 */
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/**
 * include the init.php file
 */
include 'includes/init.php';

use clagiordano\webmvc\application\Registry;
use clagiordano\webmvc\application\Router;
use clagiordano\webmvc\application\Template;

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

//echo "<pre>\$_GET['rt']: ";
//    print_r(filter_input(INPUT_GET, 'rt'));
//echo "</pre>";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php ?>
    </body>
</html>
