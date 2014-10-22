<?php

/**
 * PSR automatic autoload function
 * 
 * @param string $className
 */
function __autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    
    print "psr autoload: $fileName<br />";
    require "../$fileName";
}

//autoload("application\Controller");
//autoload("application\Registry");
//autoload("application\Template");

//use webmvc\application\Controller;
use webmvc\application\Registry;
//use webmvc\application\Template;

 /*** include the controller class ***/
// include __SITE_PATH . '/application/' . 'Controller.php';
 /*** include the registry class ***/
// include __SITE_PATH . '/application/' . 'Registry.php';
 /*** include the router class ***/
// include __SITE_PATH . '/application/' . 'Router.php';
 /*** include the template class ***/
// include __SITE_PATH . '/application/' . 'Template.php';
 
 
 /*** a new registry object ***/
 $registry = new Registry();
 