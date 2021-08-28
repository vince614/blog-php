<?php

use App\App;
use App\Models\UserModel;
use Core\Configuration\Config;
use Core\Router\Router;
use Core\Router\RouterException;

define('ROOT', __DIR__);

// Start session
session_start();

// Require autoload
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/App.php';
require __DIR__ . '/Core/Exception/Exception.php';

// Get config
$config = new Config();
$url = $config->getConfig(Config::SECURE_URL_CONFIG_CODE) ?
            $config->getConfig(Config::SECURE_URL_CONFIG_CODE) :
            $config->getConfig(Config::UNSECURE_URL_CONFIG_CODE);



// Maintenance
$maintenanceMode = $config->getConfig(Config::MAINTENANCE_MODE_CONFIG_CODE) == 1;
if ($maintenanceMode) {
    // Maintenance
}

$app = new App();
$app->app();

/** @var UserModel $userModel */
$userModel = App::getModel('user');
$user = $userModel->load(1, 'name');

$user->setName('Vince');
$userModel->save($user);
exit;

// Set router URL
$router = new Router($url);

/**
 * Index route
 * @GET & @POST route
 */
$router->get('/test', function () {});
$router->post('/test', function () {});

// Run router
try {
    $router->run();
} catch (RouterException $e) {
    echo $e->getMessage();
}