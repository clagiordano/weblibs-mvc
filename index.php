<?php

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
 include 'core/init.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        ?>
    </body>
</html>
