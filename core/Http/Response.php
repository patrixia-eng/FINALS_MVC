<?php

declare(strict_types=1);

namespace Core\Http;

final class Response
{
    public function __construct(
        private string $content,
        private int $status = 200,
        private array $headers = ['Content-Type' => 'text/html; charset=UTF-8'],
    ) {}

    public static function html(string $content, int $status = 200): self
    {
        return new self($content, $status);
    }

    public static function redirect(string $location, int $status = 302): self
    {
        return new self('', $status, ['Location' => $location]);
    }

    public static function notFound(string $message = 'Not Found'): self
    {
        return new self($message, 404);
    }

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->content;
    }
}
