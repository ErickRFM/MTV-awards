<?php

require_once __DIR__ . '/Model.php';

class Genre extends Model
{
    public static function all(): array
    {
        return self::db()->query('SELECT * FROM genres ORDER BY name ASC')->fetchAll();
    }
}
