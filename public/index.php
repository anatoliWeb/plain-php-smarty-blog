<?php

declare(strict_types=1);

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Core\Database;
use App\Core\Router;
use App\Core\View;
use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\HomePageService;

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

try {
    $database = new Database($config['database']);
    $pdo = $database->getConnection();
} catch (Throwable $e) {
    http_response_code(500);

    echo !empty($config['app']['debug'])
        ? 'Database connection error: ' . $e->getMessage()
        : 'Internal Server Error';

    exit;
}

$view = new View();
$router = new Router();

$categoryRepository = new CategoryRepository($pdo);
$articleRepository = new ArticleRepository($pdo);
$homePageService = new HomePageService($categoryRepository, $articleRepository);

$categoryModel = new Category($pdo);
$articleModel = new Article($pdo);

$homeController = new HomeController($view, $homePageService);
$categoryController = new CategoryController($view, $categoryModel, $articleModel);
$articleController = new ArticleController($view, $articleModel);

// Register application routes.
$router->get('/', function () use ($homeController): string {
    return $homeController->index();
});

$router->get('/category/{slug}', function (string $slug) use ($categoryController): string {
    return $categoryController->show($slug);
});

$router->get('/article/{slug}', function (string $slug) use ($articleController): string {
    return $articleController->show($slug);
});

// Dispatch the current request and output the response.
$response = $router->dispatch($_SERVER['REQUEST_URI'] ?? '/');

echo is_string($response) ? $response : '';
