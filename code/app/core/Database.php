<?php
class Database {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null ) {
            $config = require __DIR__ . '/../../config/database.php';
            self::$pdo = new PDO(
                    "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
                    $config['user'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );

        }

        return self::$pdo;
    }
}

