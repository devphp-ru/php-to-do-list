<?php

declare(strict_types=1);

namespace Framework\Database\Connection;

use PDO;
use InvalidArgumentException;
use Framework\Database\QueryBuilder\QueryBuilder;
use Framework\Database\Migration\Migration;

class SqliteConnection implements Connection
{

    private PDO $pdo;
    private string $database;

    public function __construct(array $config)
    {
        [
            'type' => $type,
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password,
            'charset' => $charset,
        ] = $config;

        if (empty($host) || empty($database) || empty($username)) {
            throw new InvalidArgumentException('Connection incorrectly configured.');
        }

        $this->database = $database;
        $this->pdo = new PDO(
            "{$type}:host={$host};port={$port};dbname={$database};charset={$charset}",
            $username,
            $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    public function pdo(): PDO
    {
        // TODO: Implement pdo() method.
    }

    public function query(): QueryBuilder
    {
        // TODO: Implement query() method.
    }

    public function createTable(string $name): Migration
    {
        // TODO: Implement createTable() method.
    }

    public function alterTable(string $name): Migration
    {
        // TODO: Implement alterTable() method.
    }

    public function getTables(): array
    {
        // TODO: Implement getTables() method.
    }

    public function hasTable(string $name): bool
    {
        // TODO: Implement hasTable() method.
    }

    public function dropTables(): bool
    {
        // TODO: Implement dropTables() method.
    }

    public function dropTable(string $name): bool
    {
        // TODO: Implement dropTable() method.
    }

    public function truncateTables(): bool
    {
        // TODO: Implement truncateTables() method.
    }

    public function truncateTable(string $name): bool
    {
        // TODO: Implement truncateTable() method.
    }

}
