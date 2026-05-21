<?php

declare(strict_types=1);

use App\Core\Database;
use App\Core\Router;
use App\Core\View;

// Load Composer autoload if dependencies are already installed.
// This keeps the entry point usable before running composer install.
$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require $autoloadPath;
}

// Load simple application configuration.
$config = require dirname(__DIR__) . '/config/config.php';

// Show detailed errors only in local/debug mode.
if (!empty($config['app']['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

$dbStatus = '';

try {
    // Temporary connection check.
    // This will be removed when real routing and pages are added.
    $database = new Database($config['database']);
    $database->getConnection();

    $dbStatus = ' (DB connected)';
} catch (Throwable $e) {
    $dbStatus = !empty($config['app']['debug'])
        ? ' (DB error: ' . $e->getMessage() . ')'
        : ' (DB error)';
}

$view = new View();
$router = new Router();

$router->get('/', function () use ($view, $dbStatus): string {
    return $view->render('home.tpl', [
        'title' => 'Plain PHP Smarty Blog',
        'dbStatus' => $dbStatus,
    ]);
});

$response = $router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
echo is_string($response) ? $response : '';
