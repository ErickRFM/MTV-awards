<?php

require_once __DIR__ . '/Model.php';

class Nomination extends Model
{
    public static function all(): array
    {
        $sql = "
            SELECT n.*,
                   COUNT(DISTINCT ni.id) AS nominees_count,
                   COUNT(v.id) AS votes_count
            FROM nominations n
            LEFT JOIN nomination_items ni ON ni.nomination_id = n.id
            LEFT JOIN votes v ON v.nomination_id = n.id
            GROUP BY n.id
            ORDER BY n.start_date DESC, n.id DESC
        ";

        return self::db()->query($sql)->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('nominations');
    }

    public static function allActive(): array
    {
        $statement = self::db()->prepare("
            SELECT *
            FROM nominations
            WHERE status = 'active'
              AND (start_date IS NULL OR start_date <= NOW())
              AND (end_date IS NULL OR end_date >= NOW())
            ORDER BY start_date ASC, id DESC
        ");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $statement = self::db()->prepare('SELECT * FROM nominations WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare("
            INSERT INTO nominations (title, type, category, start_date, end_date, status)
            VALUES (:title, :type, :category, :start_date, :end_date, :status)
        ");
        $statement->execute([
            'title' => $data['title'],
            'type' => $data['type'],
            'category' => $data['category'] ?: null,
            'start_date' => $data['start_date'] ?: null,
            'end_date' => $data['end_date'] ?: null,
            'status' => $data['status'] ?: 'active',
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $statement = self::db()->prepare("
            UPDATE nominations
            SET title = :title,
                type = :type,
                category = :category,
                start_date = :start_date,
                end_date = :end_date,
                status = :status
            WHERE id = :id
        ");

        return $statement->execute([
            'id' => $id,
            'title' => $data['title'],
            'type' => $data['type'],
            'category' => $data['category'] ?: null,
            'start_date' => $data['start_date'] ?: null,
            'end_date' => $data['end_date'] ?: null,
            'status' => $data['status'] ?: 'active',
        ]);
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM nominations WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }
}
