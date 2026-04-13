<?php

declare(strict_types=1);

namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Routing\Route;

class RouteTest extends TestCase
{

    public Route $route;

    public function setUp(): void
    {
        $this->route = new Route(
            'GET',
            '/',
            fn () => 'Site page',
        );
    }

    public function test_get_route_matches(): void
    {
        $method = 'GET';
        $path = '/';
        $result = $this->route->matches($method, $path);

        $this->assertTrue($result);
    }

    public function test_get_route_error(): void
    {
        $method = 'GET';
        $realPath = '/about';

        $result = $this->route->matches($method, $realPath);

        $this->assertFalse($result);
    }

}
