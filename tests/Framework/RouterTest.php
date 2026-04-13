<?php

declare(strict_types=1);

namespace Tests\Framework;

use Framework\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    private Router $router;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function test_get_home_route(): void
    {
        $method = 'GET';
        $path = '/';
        $this->router->add(
            $method,
            $path,
            fn () => 'Home page',
        );

        $result = $this->router->dispatch();

        $this->assertSame('Home page', $result);
    }

    public function test_get_404_error_route(): void
    {
        $method = 'GET';
        $path = '/about';
        $expected = 'Not Found 404';
        $this->router->add(
            $method,
            $path,
            fn () => 'Home page',
        );

        $result = $this->router->dispatch();

        $this->assertSame($expected, $result);
    }

}
