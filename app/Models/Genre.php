<?php

require_once __DIR__ . '/Model.php';

class Genre extends Model
{
    public static function all(): array
    {
        return self::db()->query('SELECT * FROM genres ORDER BY name ASC')->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('genres');
    }

    public static function find(int $id): array|false
    {
        $statement = self::db()->prepare('SELECT * FROM genres WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function findByName(string $name, ?int $excludeId = null): array|false
    {
        $sql = 'SELECT * FROM genres WHERE name = :name';
        $params = ['name' => $name];

        if ($excludeId !== null) {
            $sql .= ' AND id <> :exclude_id';
            $params['exclude_id'] = $excludeId;
        }

        $sql .= ' LIMIT 1';

        $statement = self::db()->prepare($sql);
        $statement->execute($params);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare('INSERT INTO genres (name) VALUES (:name)');
        $statement->execute([
            'name' => $data['name'],
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $statement = self::db()->prepare('UPDATE genres SET name = :name WHERE id = :id');

        return $statement->execute([
            'id' => $id,
            'name' => $data['name'],
        ]);
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM genres WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }
}
