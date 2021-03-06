<?php

// @TODO securise public folder. (droits fichier)

use App\App;
use Core\Acl\ACL;
use Core\Configuration\Config;
use Core\Controllers\ErrorController;
use Core\Router\Router;
use Core\Router\RouterException;
use Core\Utils\Request;

define('ROOT', __DIR__ .  '/..');

// Start session
session_start();

// Require autoload
require '../vendor/autoload.php';
require '../App/App.php';
require '../Core/Exception/Exception.php';

// Init app
App::init();

// Maintenance
$maintenanceMode = App::getConfig(Config::MAINTENANCE_MODE_CONFIG_CODE) == 1;
if ($maintenanceMode) {
    return new ErrorController('maintenance');
}

// Set router URL
$request = new Request();
$router = new Router($request->getUrl());

/**
 * Index route
 * @GET METHOD
 */
$router->get('/');

/**
 * Blog list route
 * @GET & @POST METHOD
 */
$router->get('/article');
$router->post('/article');

/**
 * Unique blog route
 * @GET METHOD
 */
$router->get('/article/:id', ACL::EVERYONE);
$router->post('/article/:id', ACL::LOGGED_IN);
$router->get('/article/:id/edit/', ACL::LOGGED_IN);

/**
 * Unique blog route
 * @GET @ @POST METHOD
 */
$router->get('/login', ACL::NOT_LOGGED_IN);
$router->post('/login', ACL::NOT_LOGGED_IN);
$router->get('/register', ACL::NOT_LOGGED_IN);
$router->post('/register', ACL::NOT_LOGGED_IN);

/**
 * Profile route
 * @GET METHOD
 */
$router->get('/profile/:id', ACL::EVERYONE);

/**
 * Logout route
 * @GET METHOD
 */
$router->get('/logout', [ACL::LOGGED_IN]);

/**
 * Admin route
 * @GET METHOD
 */
$router->get('/admin', ACL::ADMIN);

// Run router
try {
    $router->run();
} catch (RouterException $e) {
    echo $e->getMessage();
}