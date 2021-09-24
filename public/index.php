<?php

// @TODO securise public folder. (droits fichier)

use App\Controllers\ErrorController;
use Core\Acl\ACL;
use Core\Configuration\Config;
use Core\Controllers\Controller;
use Core\Router\Router;
use Core\Router\RouterException;
use Core\Utils\Request;

define('ROOT', __DIR__ .  '/..');

// Start session
session_start();

// Require autoload
require '../vendor/autoload.php';
require '../app/App.php';
require '../Core/Exception/Exception.php';

// Maintenance
$config = new Config();
$maintenanceMode = $config->getConfig(Config::MAINTENANCE_MODE_CONFIG_CODE) == 1;
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
$router->get('/index', null, ACL::EVERYONE);

/**
 * Index route
 * @GET & @POST METHOD
 */
$router->get('/test', null);
$router->post('/test', null);

// Run router
try {
    $router->run();
} catch (RouterException $e) {
    echo $e->getMessage();
}