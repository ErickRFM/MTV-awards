<?php

class Database
{
    private static ?PDO $pdo = null;
    private static ?array $config = null;

    public static function getConfig(): array
    {
        if (self::$config === null) {
            self::$config = require __DIR__ . '/config.php';
        }

        return self::$config;
    }

    public static function getConnection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $config = self::getConfig()['db'];
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['name'],
            $config['charset']
        );

        self::$pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return self::$pdo;
    }

    public static function getServerConnection(): PDO
    {
        $config = self::getConfig()['db'];
        $dsn = sprintf(
            'mysql:host=%s;port=%d;charset=%s',
            $config['host'],
            $config['port'],
            $config['charset']
        );

        return new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
