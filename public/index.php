<?php

declare(strict_types=1);

$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require $autoloadPath;
}

echo 'Plain PHP Smarty Blog';
