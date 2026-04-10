<?php

return static function (PDO $pdo): void {
    $passwordHash = '$2y$10$HA2E/t7Omu.sReO5i1Ok8OiDA9jV3aDUOOJGTrledc4X8VdD88OJ.';

    $pdo->exec("
        INSERT INTO roles (id, name) VALUES
        (1, 'Administrator'),
        (2, 'Manager'),
        (3, 'Audience')
        ON DUPLICATE KEY UPDATE name = VALUES(name)
    ");

    $pdo->exec("
        INSERT INTO genres (id, name) VALUES
        (1, 'Pop'),
        (2, 'Rock'),
        (3, 'Hip Hop'),
        (4, 'Electronic'),
        (5, 'Regional Mexicano'),
        (6, 'Latin')
        ON DUPLICATE KEY UPDATE name = VALUES(name)
    ");

    $statement = $pdo->prepare("
        INSERT INTO users (username, email, password, display_name, role_id, avatar, status)
        VALUES (:username, :email, :password, :display_name, :role_id, :avatar, 1)
        ON DUPLICATE KEY UPDATE
            password = VALUES(password),
            display_name = VALUES(display_name),
            role_id = VALUES(role_id),
            avatar = VALUES(avatar),
            status = VALUES(status)
    ");

    $statement->execute([
        'username' => 'adminmtv',
        'email' => 'usermtv@awards.com',
        'password' => $passwordHash,
        'display_name' => 'Administrador MTV Awards',
        'role_id' => 1,
        'avatar' => 'uploads/users/man.png',
    ]);
};
