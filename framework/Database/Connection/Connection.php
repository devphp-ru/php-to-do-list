<?php

declare(strict_types=1);

namespace Framework\Database\Connection;

use Framework\Database\Migration\Migration;
use Framework\Database\QueryBuilder\QueryBuilder;
use PDO;

interface Connection
{
    public function pdo(): PDO;

    public function query(): QueryBuilder;

    public function createTable(string $name): Migration;

    public function alterTable(string $name): Migration;

    public function getTables(): array;

    public function hasTable(string $name): bool;

    public function dropTables(): bool;

    public function dropTable(string $name): bool;

    public function truncateTables(): bool;

    public function truncateTable(string $name): bool;

}
