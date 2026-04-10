<?php

require_once __DIR__ . '/../config/Database.php';

$config = Database::getConfig();
$dbConfig = $config['db'];
$server = Database::getServerConnection();
$databaseName = $dbConfig['name'];
$charset = $dbConfig['charset'];
$collation = $dbConfig['collation'];

$server->exec(sprintf(
    'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s',
    $databaseName,
    $charset,
    $collation
));
$server->exec(sprintf('USE `%s`', $databaseName));

$migrationFiles = glob(__DIR__ . '/migrations/*.php');
sort($migrationFiles);

$messages = [];

foreach ($migrationFiles as $migrationFile) {
    $migration = require $migrationFile;

    if (!is_callable($migration)) {
        throw new RuntimeException("La migracion {$migrationFile} no es valida.");
    }

    $migration($server);
    $messages[] = 'Ejecutada: ' . basename($migrationFile);
}

if (PHP_SAPI === 'cli') {
    foreach ($messages as $message) {
        echo $message . PHP_EOL;
    }
    echo PHP_EOL . 'Base de datos lista.' . PHP_EOL;
    exit;
}

header('Content-Type: text/html; charset=utf-8');
echo '<h1>Migraciones MTV Awards</h1><ul>';
foreach ($messages as $message) {
    echo '<li>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</li>';
}
echo '</ul><p>Base de datos lista.</p>';
