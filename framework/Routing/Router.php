<?php
declare(strict_types=1);

namespace Framework\Routing;

use Exception;
use Throwable;

class Router
{
    protected array $routes = [];
    protected array $errorHandlers = [];
    protected Route $currentRoute;

    public function add(
        string $method,
        string $path,
        callable $handler,
    ): Route
    {
        return $this->routes[] = new Route($method, $path, $handler);
    }

    public function current(): ?Route
    {
        return $this->currentRoute;
    }

    public function errorHandler(int $code, callable $handler): void
    {
        $this->errorHandlers[$code] = $handler;
    }

    public function dispatchNotAllowed(): mixed
    {
        $this->errorHandlers[400] ??= fn () => 'Not allowed 400';

        return $this->errorHandlers[400]();
    }

    public function dispatchNotFound(): mixed
    {
        $this->errorHandlers[404] ??= fn () => 'Not found 404';

        return $this->errorHandlers[404]();
    }

    public function dispatchError(?object $e = null): mixed
    {
        $this->errorHandlers[500] ??= fn () => 'Internal Server Error ' . $e->getMessage();

        return $this->errorHandlers[500]();
    }

    /**
     * @throws Exception
     */
    public function route(string $name, array $parameters = []): string
    {
        foreach ($this->routes as $route) {
            if ($route->name() === $name) {
                $finds = [];
                $replaces = [];

                foreach ($parameters as $key => $value) {
                    $finds[] = "{{$key}}";
                    $replaces[] = $value;
                    $finds[] = "{{$key}?}";
                    $replaces[] = $value;
                }

                $path = $route->path();
                $path = str_replace($finds, $replaces, $path);

                return preg_replace('#{[^}]+}#', '', $path);
            }
        }

        throw new Exception('Error: Маршрута с таким названием нет.');
    }

    public function dispatch(): mixed
    {
        $paths = $this->paths();
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestPath = $_SERVER['REQUEST_URI'] ?? '/';
        $matching = $this->match($requestMethod, $requestPath);

        if ($matching) {
            $this->currentRoute = $matching;
            try {
                return $matching->dispatch();
            } catch(Throwable $e) {
                return $this->dispatchError($e);
            }
        }

        if (in_array($requestPath, $paths)) {
            return $this->dispatchError();
        }

        return $this->dispatchNotFound();
    }

    private function paths(): array
    {
        foreach ($this->routes ?? [] as $route) {
            $paths[] = $route->path();
        }

        return $paths ?? [];
    }

    private function match(string $method, string $path): ?Route
    {
        return array_find($this->routes, fn($route) => $route->matches($method, $path));
    }

}
