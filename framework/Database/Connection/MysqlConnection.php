<?php

namespace Framework\Database\Connection;

use PDO;
use InvalidArgumentException;
use Framework\Database\Migration\MysqlMigration;
use Framework\Database\QueryBuilder\MysqlQueryBuilder;

class MysqlConnection implements Connection
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
        return $this->pdo;
    }

    public function query(): MysqlQueryBuilder
    {
        return new MysqlQueryBuilder($this);
    }

    public function createTable(string $name): MysqlMigration
    {
        return new MysqlMigration($this, $name, 'create');
    }

    public function alterTable(string $name): MysqlMigration
    {
        return new MysqlMigration($this, $name, 'alter');
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
