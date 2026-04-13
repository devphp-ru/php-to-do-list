<?php

declare(strict_types=1);

namespace Framework\Http;

final class Session
{

    public function __construct(private readonly array $config)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function getSession(): array
    {
        return $_SESSION;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$this->config['prefix'] . $key]);
    }

    public function get(?string $key = null, mixed $default = null): mixed
    {
        return $_SESSION[$this->config['prefix'] . $key] ?? $default;
    }

    public function put(string $key, mixed $value): self
    {
        $_SESSION[$this->config['prefix'] . $key] = $value;

        return $this;
    }

    public function forget(string $key): self
    {
        unset($_SESSION[$this->config['prefix'] . $key]);

        return $this;
    }

    public function flush(): self
    {
        session_reset();

        return $this;
    }

}
