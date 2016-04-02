# weblibs-mvc
weblibs-mvc is an simple and lightweight php routing component.
This component can have a RESTful support simply adding an *.htaccess* file, see below for more details.

Based on http://php-html.net/tutorials/model-view-controller-in-php/<br />
Based on http://phpro.org/tutorials/Model-View-Controller-MVC.html#9

## Installation
The recommended way to install weblibs-mvc is through [Composer](https://getcomposer.org).
```bash
composer require clagiordano/weblibs-mvc
```

### Adding RESTful support to destination project
Simply add into yours project root a file named ***.htaccess*** <br />
*(webserver must be allow override)* which contains the following lines:
```http
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?rt=$1 [L,QSA]
```

this simple steps allow your application make RESTful calls like:

```http
http://www.example.com/clients/68563
http://www.example.com/access/login
http://www.example.com/chart/
http://www.example.com/products/6574
``` 

## Description of the main components

### Controller
The Controller is the C in MVC.
The base controller is a simple abstract class that defines the
structure of all controllers.
By including the registry here, the registry is available to all class
that extend from the base controller. An index() method has also been
included in the base controller which means all controller classes that
extend from it must have an index() method themselves.

### Registry
The registry is an object where site wide variables can be stored without
the use of globals.
By passing the registry object to the controllers that need them,
we avoid pollution of the global namespace and render our variables safe.
We need to be able to set registry variables and to get them.

### Routing
The router class is responsible for loading up the correct controller.
It does nothing else. The value of the controller comes from the URL.

### Template
The templates themselves are basically HTML files with a little PHP embedded.
Do not let the separation Nazi's try to tell you that you need to have full
separation of HTML and PHP.
Remember, PHP is an embeddable scripting language.
This is the sort of task it is designed for and makes an efficient
templating language. The template files belong in the views directory.

## Legal
*Copyright (C) Claudio Giordano <claudio.giordano@autistici.org>*
