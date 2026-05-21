<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $getRoutes = [];

    public function get(string $path, callable $handler): void
    {
        $this->getRoutes[$this->normalizePath($path)] = $handler;
    }

    public function dispatch(string $requestUri): mixed
    {
        // Keep routing independent from query parameters like ?page=2.
        $path = parse_url($requestUri, PHP_URL_PATH);
        $normalizedPath = $this->normalizePath($path ?: '/');

        if (!isset($this->getRoutes[$normalizedPath])) {
            http_response_code(404);

            return 'Page not found';
        }

        return ($this->getRoutes[$normalizedPath])();
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path);

        if ($path === '') {
            return '/';
        }

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        // Allow both "/category" and "/category/" for simple static routes.
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return $path === '' ? '/' : $path;
    }
}