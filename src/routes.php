<?php

use Framework\Routing\Router;
use App\Http\Controllers\IndexController;

return function (Router $router) {
    $router->add(
        'GET',
        '/',
        [IndexController::class, 'index'],
    );
};
