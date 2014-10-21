<?php

function __autoload($className) // PSR
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

//function __autoload($class_name) 
//{
//    print "__autoload $class_name<br />";
//    
//    //$filename = strtolower($class_name) . '.php';
//    //$file = __SITE_PATH . '/model/' . $filename;
//    $file = "../" . $class_name . ".php";
//    print "__autoload $file<br />";
//    
//    if (file_exists($file) == false) {
//        return false;
//    }
//    include ($file);
//}

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
 