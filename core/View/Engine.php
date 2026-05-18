<?php

declare(strict_types=1);

namespace Core\View;

final class Engine
{
    public function __construct(
        private string $viewsPath,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public function render(string $view, array $data = []): string
    {
        $file = $this->viewsPath . '/' . str_replace('.', '/', $view) . '.php';

        if (!is_file($file)) {
            throw new \RuntimeException("View [{$view}] not found.");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $file;

        return (string) ob_get_clean();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function page(string $view, array $data = [], string $layout = 'layouts/main'): string
    {
        $data['content'] = $this->render($view, $data);

        return $this->render($layout, $data);
    }
}
