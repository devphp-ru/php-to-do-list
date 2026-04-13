<?php

declare(strict_types=1);

namespace Framework\Http;

use InvalidArgumentException;

final class Response
{

    public const string REDIRECT = 'REDIRECT';
    public const string HTML = 'HTML';
    public const string JSON = 'JSON';

    private string $type = self::HTML;
    private string $redirect = '/';
    private mixed $content = null;
    private int $status = HttpStatusCode::OK;
    private array $headers = [];

    public function content(mixed $content = null): self|null
    {
        if (is_null($content)) {
            return $this->content;
        }

        $this->content = $content;

        return $this;
    }

    public function status(?int $status = null): self|int
    {
        if (is_null($status)) {
            return $this->status;
        }

        $this->status = $status;

        return $this;
    }

    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function redirect(?string $redirect = null): self|string|null
    {
        if (is_null($redirect)) {
            return $this->redirect;
        }

        $this->redirect = $redirect;
        $this->type = self::REDIRECT;

        return $this;
    }

    public function json(mixed $content): self
    {
        $this->content = $content;
        $this->type = self::JSON;

        return $this;
    }

    public function type(?string $type = null): self|string
    {
        if (is_null($type)) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    public function send(): void
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }

        if ($this->type === self::HTML) {
            header('Content-Type: text/html');
            http_response_code($this->status);
            print $this->content;
            die;
        } elseif ($this->type === self::JSON) {
            header('Content-Type: application/json');
            http_response_code($this->status);
            print json_encode($this->content, JSON_UNESCAPED_UNICODE);
            die;
        } elseif ($this->type === self::REDIRECT) {
            header('Location: ' . $this->redirect);
            die;
        }

        throw new InvalidArgumentException($this->type . ' не является распознанным типом.');
    }

}
