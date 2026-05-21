<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
    private array $config;
    private ?PDO $connection = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConnection(): PDO
    {
        // Create the PDO connection only once and reuse it during the request.
        if ($this->connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $this->config['host'],
                $this->config['port'],
                $this->config['database'],
                $this->config['charset']
            );

            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                [
                    // Throw exceptions instead of silent SQL errors.
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    // Return rows as associative arrays by default.
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                    // Use native prepared statements when possible.
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }

        return $this->connection;
    }
}