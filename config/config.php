<?php

declare(strict_types=1);

// Simple config file for a framework-free project.
// Values are read from environment variables with safe local defaults.
return [
    'app' => [
        'env' => getenv('APP_ENV') ?: 'local',

        // APP_DEBUG controls error output in public/index.php.
        'debug' => filter_var(getenv('APP_DEBUG') ?: true, FILTER_VALIDATE_BOOLEAN),
    ],

    'database' => [
        // Inside Docker, DB_HOST should point to the MySQL service name.
        'host' => getenv('DB_HOST') ?: 'mysql',

        // Internal MySQL port in Docker network.
        'port' => getenv('DB_PORT') ?: '3306',

        'database' => getenv('DB_DATABASE') ?: 'blog',
        'username' => getenv('DB_USERNAME') ?: 'blog_user',
        'password' => getenv('DB_PASSWORD') ?: 'blog_password',

        // Keep utf8mb4 for full Unicode support.
        'charset' => 'utf8mb4',
    ],
];