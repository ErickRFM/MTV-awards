<?php

require_once __DIR__ . '/../../config/Database.php';

class Model
{
    protected static function db(): PDO
    {
        return Database::getConnection();
    }

    protected static function countTable(string $table): int
    {
        return (int) self::db()->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
    }
}
