<?php

require_once __DIR__ . '/Model.php';

class NominationItem extends Model
{
    public static function byNomination(int $nominationId): array
    {
        $statement = self::db()->prepare("
            SELECT ni.*,
                   a.name AS artist_name,
                   a.photo AS artist_photo,
                   al.title AS album_title,
                   al.cover AS album_cover,
                   ar.name AS album_artist_name,
                   COUNT(v.id) AS votes_count
            FROM nomination_items ni
            LEFT JOIN artists a ON a.id = ni.artist_id
            LEFT JOIN albums al ON al.id = ni.album_id
            LEFT JOIN artists ar ON ar.id = al.artist_id
            LEFT JOIN votes v ON v.nomination_item_id = ni.id
            WHERE ni.nomination_id = :nomination_id
            GROUP BY ni.id
            ORDER BY votes_count DESC, ni.id DESC
        ");
        $statement->execute(['nomination_id' => $nominationId]);

        return $statement->fetchAll();
    }

    public static function find(int $id): array|false
    {
        $statement = self::db()->prepare('SELECT * FROM nomination_items WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare("
            INSERT INTO nomination_items (nomination_id, artist_id, album_id)
            VALUES (:nomination_id, :artist_id, :album_id)
        ");
        $statement->execute([
            'nomination_id' => $data['nomination_id'],
            'artist_id' => $data['artist_id'] ?: null,
            'album_id' => $data['album_id'] ?: null,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM nomination_items WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }
}
