<?php

declare(strict_types=1);

namespace Framework\Http;

final class Request
{

    private static ?Request $instance = null;
    public const string GET = 'GET';
    public const string POST = 'POST';
    public const string PUT = 'PUT';
    public const string PATCH = 'PATCH';
    public const string DELETE = 'DELETE';

    public function __construct() {}

    public static function capture(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function instance(): self
    {
        return $this;
    }

    public function requestUri(?string $uri = null): string
    {
        return $_SERVER['REQUEST_URI'] ?? $uri;
    }

    public function requestMethod(?string $method = null): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? $method;
    }

    public function httpReferer(?string $referer = null): string
    {
        return $_SERVER['HTTP_REFERER'] ?? $referer;
    }

    public function isFile(): bool
    {
        return !empty($_FILES);
    }

    public function queryGet(): string|array
    {
        return $_GET;
    }

    public function queryPost(): array
    {
        return $_POST;
    }

    public function file(?string $name = null): array
    {
        return !is_null($name) ? $_FILES[$name] : $_FILES;
    }

    public function isGet(): bool
    {
        return $this->requestMethod() === self::GET;
    }

    public function isPost(): bool
    {
        return $this->requestMethod() === self::POST;
    }

    public function has(mixed $name): bool
    {
        if ($this->isGet()) {
            $get = $this->queryGet();
            $params = $this->trimGet($get);
        } else {
            $post = $this->queryPost();
            $params = $this->trimPost($post);
        }

        return !empty($params[$name]);
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function get(?string $name = null, ?string $type = null): mixed
    {
        $result = $this->getParams();

        if (is_null($name)) {
            return $result;
        }

        $value = $result[$name];

        return $this->getValue($value, $type);
    }

    private function getParams(): array
    {
        $result = $this->queryGet();

        return $this->trimGet($result);
    }

    public function post(?string $name = null, ?string $type = null): mixed
    {
        $result = $this->postParams();

        if (is_null($name)) {
            return $result;
        }

        $value = $result[$name];

        return $this->getValue($value, $type);
    }

    private function postParams(): array
    {
        $result = $this->queryPost();

        return $this->trimPost($result);
    }

    public function input(mixed $name, ?string $type = null, mixed $default = null): mixed
    {
        $params = $this->trimValues();
        $value = $params[$name];

        return $this->getValue($value ?? $default, $type);
    }

    public function getValue(mixed $value, ?string $type = null, mixed $default = null): mixed
    {
        if (is_null($value) && is_null($type)) {
            return null;
        }

        if (!is_null($default)) {
            $value = $default;
        }

        if (is_null($type)) {
            return $value;
        }

        if (!empty($value) && is_array($value)) {
            $value = reset($value);
        }

        if ($type === 'string' || $type === 'str') {
            return strval(preg_replace('#[^\p{L}\p{Nd}\d\s_\-\.\%\s\@]#ui', '', (string)$value));
        }

        if ($type === 'integer' || $type === 'int') {
            return intval($value);
        }

        if ($type === 'float') {
            return floatval($value);
        }

        if ($type === 'boolean' || $type === 'bool') {
            return !empty($value);
        }

        return $value;
    }

    private function trimValues(): array
    {
        $paramValues = $this->isGet()
            ? $this->queryGet()
            : $this->queryPost();

        if (is_string($paramValues)) {
            return $this->trimGet($paramValues);
        }

        return $this->trimPost($paramValues);
    }

    private function trimGet(string $uri): array
    {
        $query = parse_url($uri, PHP_URL_QUERY);

        if (is_null($query)) {
            return [];
        }

        $parts = explode('&', $query);
        $result = [];

        foreach ($parts as $part) {
            [$key, $value] = explode('=', $part);
            $result[$key] = trim($value);
        }

        return $result;
    }

    private function trimPost(array $params): array
    {
        $result = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $result[$key][$k] = trim((string)$v);
                }
            } else {
                $result[$key] = trim((string)$value);
            }
        }

        return $result;
    }

}
