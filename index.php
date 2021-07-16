<?php
use Router\Router;
use Router\RouterException;

// Define root
define('ROOT', __DIR__);

// Start session
session_start();

// Require
require_once "Router/Router.php";
require_once "Router/Route.php";
require_once "Router/RouterException.php";
require_once "General.php";

// General class
$general = new General();

// Load configuration
try {
    $general->start($general->getUrl());
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// Set router URL
$router = new Router($general->getUrl());

// Run router
try {
    $router->run();
} catch (RouterException $e) {
    echo $e->getMessage();
}