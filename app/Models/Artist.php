<?php

require_once __DIR__ . '/Model.php';

class Artist extends Model
{
    public static function all(): array
    {
        $sql = "
            SELECT a.*, COUNT(DISTINCT al.id) AS albums_count
            FROM artists a
            LEFT JOIN albums al ON al.artist_id = a.id
            GROUP BY a.id
            ORDER BY a.created_at DESC, a.id DESC
        ";

        return self::db()->query($sql)->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('artists');
    }

    public static function top(int $limit = 6): array
    {
        $statement = self::db()->prepare("
            SELECT a.*, COUNT(v.id) AS votes_count
            FROM artists a
            LEFT JOIN nomination_items ni ON ni.artist_id = a.id
            LEFT JOIN votes v ON v.nomination_item_id = ni.id
            GROUP BY a.id
            ORDER BY votes_count DESC, a.name ASC
            LIMIT :limit
        ");
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $statement = self::db()->prepare("
            SELECT a.*, COUNT(DISTINCT al.id) AS albums_count
            FROM artists a
            LEFT JOIN albums al ON al.artist_id = a.id
            WHERE a.id = :id
            GROUP BY a.id
        ");
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare("
            INSERT INTO artists (name, pseudonym, sex, nationality, biography, photo, status)
            VALUES (:name, :pseudonym, :sex, :nationality, :biography, :photo, :status)
        ");
        $statement->execute([
            'name' => $data['name'],
            'pseudonym' => $data['pseudonym'] ?: null,
            'sex' => $data['sex'] ?: null,
            'nationality' => $data['nationality'] ?: null,
            'biography' => $data['biography'] ?: null,
            'photo' => $data['photo'] ?: null,
            'status' => $data['status'] ?? 1,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $statement = self::db()->prepare("
            UPDATE artists
            SET name = :name,
                pseudonym = :pseudonym,
                sex = :sex,
                nationality = :nationality,
                biography = :biography,
                photo = :photo,
                status = :status
            WHERE id = :id
        ");

        return $statement->execute([
            'id' => $id,
            'name' => $data['name'],
            'pseudonym' => $data['pseudonym'] ?: null,
            'sex' => $data['sex'] ?: null,
            'nationality' => $data['nationality'] ?: null,
            'biography' => $data['biography'] ?: null,
            'photo' => $data['photo'] ?: null,
            'status' => $data['status'] ?? 1,
        ]);
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM artists WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }
}
