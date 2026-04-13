<?php

declare(strict_types=1);

namespace Tests\Framework;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public Request $request;

    public function setUp(): void
    {
        $this->request = Request::capture();
    }

    public function test_get_request_uri(): void
    {
        $path = '/about';
        $result = $this->request->requestUri($path);

        $this->assertSame($path, $result);
    }

    public function test_get_request_method_get(): void
    {
        $method = 'GET';
        $result = $this->request->requestMethod($method);

        $this->assertSame($method, $result);
    }

    public function test_get_request_method_post(): void
    {
        $method = 'POST';
        $result = $this->request->requestMethod($method);

        $this->assertSame($method, $result);
    }

    public function test_get_request_parameters_get(): void
    {
        $_GET = 'https://test.ru?page=2&min=5';
        $expected = [
            'page' => '2',
            'min' => '5',
        ];

        $result = $this->request->get();

        $this->assertSame($expected, $result);
    }

    public function test_get_request_parameters_post(): void
    {
        $expected = $_POST = [
            'id' => '1',
            'name' => 'test',
        ];

        $result = $this->request->post();

        $this->assertSame($expected, $result);
    }

    public function test_get_typed_property(): void
    {
        $value = '1';
        $type = 'int';
        $expected = 1;

        $result = $this->request->getValue($value, $type);

        $this->assertSame($expected, $result);
    }

    public function test_get_default_value(): void
    {
        $value = '';
        $default = 123;
        $type = 'string';
        $expected = '123';

        $result = $this->request->getValue($value, $type, $default);

        $this->assertSame($expected, $result);
    }

    public function test_get_one_value_from_request_get(): void
    {
        $_GET = 'https://test.ru?page=2&min=5';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $name = 'page';
        $type = 'int';
        $expected = 2;

        $result = $this->request->input($name, $type);

        $this->assertSame($expected, $result);
    }

    public function test_get_one_value_from_request_post(): void
    {
        $_POST = [
            'id' => '1',
            'name' => 'test',
            'confirm' => '1',
        ];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $name = 'confirm';
        $type = 'bool';

        $result = $this->request->input($name, $type);

        $this->assertTrue($result);
    }

}
