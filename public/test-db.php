<?php

require_once __DIR__ . '/../config/Database.php';

try {
    $pdo = Database::getConnection();
    $database = Database::getConfig()['db']['name'];
    echo 'Conexion OK a ' . htmlspecialchars($database, ENT_QUOTES, 'UTF-8');
} catch (Throwable $exception) {
    echo 'ERROR => ' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8');
}
