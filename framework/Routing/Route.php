<?php
declare(strict_types=1);

namespace Framework\Routing;

class Route
{

    protected array $parameters = [];
    protected ?string $name = null;

    public function __construct(
        protected string $method,
        protected string $path,
        protected mixed $handler,
    ) {}

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function dispatch(): mixed
    {
        return call_user_func($this->handler);
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function name(?string $name = null): static|string|null
    {
        if ($name !== null) {
            $this->name = $name;

            return $this;
        }

        return $this->name;
    }

    public function matches(string $method, string $path): bool
    {
        if ($this->method === $method && $this->path === $path) {
            return true;
        }

        $parameterNames = [];
        $normalisePath = $this->normalisePath($this->path);
        $pattern = preg_replace_callback(
            '#{([^}]+)}/#',
            function (array $found) use (&$parameterNames): string {
                $parameterNames[] = rtrim($found[1], '?');

                if (str_ends_with($found[1], '?')) {
                    return '([^/]*)(?:/?)';
                }

                return '([^/]+)/';
            }, $normalisePath);

        if (!str_contains($pattern, '+') && !str_contains($pattern, '*')) {
            return false;
        }

        preg_match_all("#{$pattern}#", $this->normalisePath($path), $matches);

        $parameterValues = [];

        if (count($matches[1]) > 0) {
            foreach ($matches[1] as $value) {
                if ($value) {
                    $parameterValues[] = $value;
                    continue;
                }

                $parameterValues[] = null;
            }

            $emptyValues = array_fill(0, count($parameterNames), null);
            $parameterValues += $emptyValues;
            $this->parameters = array_combine($parameterNames, $parameterValues);

            return true;
        }

       return false;
    }

    private function normalisePath(string $path): string
    {
        $result = trim($path, '/');
        $result = "/{$result}/";

        return preg_replace('/[\/]{2,}/', '/', $result);
    }

}
