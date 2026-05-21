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

        if (isset($this->getRoutes[$normalizedPath])) {
            return ($this->getRoutes[$normalizedPath])();
        }

        foreach ($this->getRoutes as $routePath => $handler) {
            $params = $this->matchRoute($routePath, $normalizedPath);

            if ($params === null) {
                continue;
            }

            return $handler(...array_values($params));
        }

        http_response_code(404);

        return 'Page not found';
    }

    private function matchRoute(string $routePath, string $requestPath): ?array
    {
        if (!str_contains($routePath, '{')) {
            return null;
        }

        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return null;
        }

        $params = [];

        foreach ($routeParts as $index => $routePart) {
            $requestPart = $requestParts[$index];

            if ($routePart !== '' && $routePart[0] === '{' && str_ends_with($routePart, '}')) {
                $paramName = trim($routePart, '{}');

                if ($paramName === '') {
                    return null;
                }

                $params[$paramName] = urldecode($requestPart);
                continue;
            }

            if ($routePart !== $requestPart) {
                return null;
            }
        }

        return $params;
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

        // Allow both "/category/name" and "/category/name/".
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return $path === '' ? '/' : $path;
    }
}