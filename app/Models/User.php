<?php

require_once __DIR__ . '/Model.php';

class User extends Model
{
    public static function all(): array
    {
        $sql = "
            SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON r.id = u.role_id
            ORDER BY u.created_at DESC, u.id DESC
        ";

        return self::db()->query($sql)->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('users');
    }

    public static function roles(): array
    {
        return self::db()->query('SELECT * FROM roles ORDER BY id ASC')->fetchAll();
    }

    public static function findByEmail(string $email): array|false
    {
        $statement = self::db()->prepare("
            SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON r.id = u.role_id
            WHERE u.email = :email
            LIMIT 1
        ");
        $statement->execute(['email' => $email]);

        return $statement->fetch();
    }

    public static function findByUsername(string $username): array|false
    {
        $statement = self::db()->prepare("
            SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON r.id = u.role_id
            WHERE u.username = :username
            LIMIT 1
        ");
        $statement->execute(['username' => $username]);

        return $statement->fetch();
    }

    public static function findById(int $id): array|false
    {
        $statement = self::db()->prepare("
            SELECT u.*, r.name AS role_name
            FROM users u
            LEFT JOIN roles r ON r.id = u.role_id
            WHERE u.id = :id
            LIMIT 1
        ");
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare("
            INSERT INTO users (username, email, password, display_name, role_id, avatar, status, updated_at)
            VALUES (:username, :email, :password, :display_name, :role_id, :avatar, :status, NOW())
        ");
        $statement->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'display_name' => $data['display_name'] ?: $data['username'],
            'role_id' => $data['role_id'] ?? 3,
            'avatar' => $data['avatar'] ?? null,
            'status' => $data['status'] ?? 1,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $fields = [
            'username = :username',
            'email = :email',
            'display_name = :display_name',
            'role_id = :role_id',
            'avatar = :avatar',
            'status = :status',
            'updated_at = NOW()',
        ];

        $parameters = [
            'id' => $id,
            'username' => $data['username'],
            'email' => $data['email'],
            'display_name' => $data['display_name'] ?: $data['username'],
            'role_id' => $data['role_id'] ?? 3,
            'avatar' => $data['avatar'] ?? null,
            'status' => $data['status'] ?? 1,
        ];

        if (!empty($data['password'])) {
            $fields[] = 'password = :password';
            $parameters['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $statement = self::db()->prepare($sql);

        return $statement->execute($parameters);
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM users WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }
}
