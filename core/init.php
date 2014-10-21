<?php
 /*** include the controller class ***/
 include __SITE_PATH . '/core/' . 'controller_base.class.php';
 /*** include the registry class ***/
 include __SITE_PATH . '/core/' . 'Registry.php';
 /*** include the router class ***/
 include __SITE_PATH . '/core/' . 'router.class.php';
 /*** include the template class ***/
 include __SITE_PATH . '/core/' . 'template.class.php';
 
 /*** auto load model classes ***/
function __autoload($class_name) {
    $filename = strtolower($class_name) . '.php';
    $file = __SITE_PATH . '/model/' . $filename;
    if (file_exists($file) == false) {
        return false;
    }
    include ($file);
}

/**
 * PSR AUTOLOADER
 */
//function autoload($className)
//{
//    $className = ltrim($className, '\\');
//    $fileName  = '';
//    $namespace = '';
//    if ($lastNsPos = strrpos($className, '\\')) {
//        $namespace = substr($className, 0, $lastNsPos);
//        $className = substr($className, $lastNsPos + 1);
//        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
//    }
//    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
//
//    require $fileName;
//}
 /*** a new registry object ***/
 $registry = new Registry();