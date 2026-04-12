<?php

use Framework\Routing\Router;

return function (Router $router) {
    $router->add(
        'GET',
        '/',
        fn () => view('home/index', ['number' => 24]),
    );
};
