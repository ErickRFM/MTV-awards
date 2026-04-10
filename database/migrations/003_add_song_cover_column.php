<?php

return static function (PDO $pdo): void {
    $database = (string) $pdo->query('SELECT DATABASE()')->fetchColumn();
    if ($database === '') {
        return;
    }

    $statement = $pdo->prepare("
        SELECT COUNT(*)
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = :schema
          AND TABLE_NAME = 'songs'
          AND COLUMN_NAME = 'cover'
    ");
    $statement->execute(['schema' => $database]);

    if ((int) $statement->fetchColumn() === 0) {
        $pdo->exec("ALTER TABLE songs ADD COLUMN cover VARCHAR(255) DEFAULT NULL AFTER title");
    }
};
