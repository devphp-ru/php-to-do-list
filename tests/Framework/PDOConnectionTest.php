<?php

declare(strict_types=1);

namespace Tests\Framework;

use PDO;
use Framework\Database\Connection\MysqlDriver\MysqlConnection;
use PHPUnit\Framework\TestCase;

class PDOConnectionTest extends TestCase
{

    public function test_pdo_connection(): void
    {
        $config = require getcwd() . '/config/database.php';
        $connection = new MysqlConnection($config['mysql']);

        $this->assertInstanceOf(PDO::class, $connection->pdo());
    }

}
