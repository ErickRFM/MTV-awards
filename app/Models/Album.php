<?php

require_once __DIR__ . '/Model.php';

class Album extends Model
{
    public static function all(): array
    {
        $sql = "
            SELECT al.*, ar.name AS artist_name, g.name AS genre_name
            FROM albums al
            INNER JOIN artists ar ON ar.id = al.artist_id
            LEFT JOIN genres g ON g.id = al.genre_id
            ORDER BY al.release_date DESC, al.id DESC
        ";

        return self::db()->query($sql)->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('albums');
    }

    public static function top(int $limit = 6): array
    {
        $statement = self::db()->prepare("
            SELECT al.*, ar.name AS artist_name, COUNT(v.id) AS votes_count
            FROM albums al
            INNER JOIN artists ar ON ar.id = al.artist_id
            LEFT JOIN nomination_items ni ON ni.album_id = al.id
            LEFT JOIN votes v ON v.nomination_item_id = ni.id
            GROUP BY al.id
            ORDER BY votes_count DESC, al.title ASC
            LIMIT :limit
        ");
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $statement = self::db()->prepare("
            SELECT al.*, ar.name AS artist_name, g.name AS genre_name
            FROM albums al
            INNER JOIN artists ar ON ar.id = al.artist_id
            LEFT JOIN genres g ON g.id = al.genre_id
            WHERE al.id = :id
            LIMIT 1
        ");
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare("
            INSERT INTO albums (artist_id, title, release_date, description, cover, genre_id)
            VALUES (:artist_id, :title, :release_date, :description, :cover, :genre_id)
        ");
        $statement->execute([
            'artist_id' => $data['artist_id'],
            'title' => $data['title'],
            'release_date' => $data['release_date'] ?: null,
            'description' => $data['description'] ?: null,
            'cover' => $data['cover'] ?: null,
            'genre_id' => $data['genre_id'] ?: null,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $statement = self::db()->prepare("
            UPDATE albums
            SET artist_id = :artist_id,
                title = :title,
                release_date = :release_date,
                description = :description,
                cover = :cover,
                genre_id = :genre_id
            WHERE id = :id
        ");

        return $statement->execute([
            'id' => $id,
            'artist_id' => $data['artist_id'],
            'title' => $data['title'],
            'release_date' => $data['release_date'] ?: null,
            'description' => $data['description'] ?: null,
            'cover' => $data['cover'] ?: null,
            'genre_id' => $data['genre_id'] ?: null,
        ]);
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM albums WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }

    public static function findByArtist(int $artistId): array
    {
        $statement = self::db()->prepare("
            SELECT al.*, g.name AS genre_name
            FROM albums al
            LEFT JOIN genres g ON g.id = al.genre_id
            WHERE al.artist_id = :artist_id
            ORDER BY al.release_date DESC, al.id DESC
        ");
        $statement->execute(['artist_id' => $artistId]);

        return $statement->fetchAll();
    }
}
