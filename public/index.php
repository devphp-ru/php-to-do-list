<?php
declare(strict_types=1);
error_reporting(-1);

require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Framework\Routing\Router();
$routes = require_once __DIR__ . '/../src/routes.php';
$routes($router);

echo $router->dispatch();
