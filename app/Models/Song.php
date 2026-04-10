<?php

require_once __DIR__ . '/Model.php';

class Song extends Model
{
    public function all(): array
    {
        $sql = "
            SELECT s.*, al.title AS album_title, al.cover AS album_cover, ar.name AS artist_name, g.name AS genre_name
            FROM songs s
            LEFT JOIN albums al ON al.id = s.album_id
            LEFT JOIN artists ar ON ar.id = al.artist_id
            LEFT JOIN genres g ON g.id = s.genre_id
            ORDER BY s.release_date DESC, s.id DESC
        ";

        return self::db()->query($sql)->fetchAll();
    }

    public static function countAll(): int
    {
        return self::countTable('songs');
    }

    public function find(int $id): array|false
    {
        $statement = self::db()->prepare("
            SELECT s.*, al.title AS album_title, al.cover AS album_cover, ar.name AS artist_name
            FROM songs s
            LEFT JOIN albums al ON al.id = s.album_id
            LEFT JOIN artists ar ON ar.id = al.artist_id
            WHERE s.id = :id
            LIMIT 1
        ");
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function create(array $data): bool
    {
        $statement = self::db()->prepare("
            INSERT INTO songs (album_id, title, cover, release_date, genre_id, mp3_url, video_url)
            VALUES (:album_id, :title, :cover, :release_date, :genre_id, :mp3_url, :video_url)
        ");

        return $statement->execute([
            'album_id' => $data['album_id'] ?: null,
            'title' => $data['title'],
            'cover' => $data['cover'] ?: null,
            'release_date' => $data['release_date'] ?: null,
            'genre_id' => $data['genre_id'] ?: null,
            'mp3_url' => $data['mp3_url'] ?: null,
            'video_url' => $data['video_url'] ?: null,
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $statement = self::db()->prepare("
            UPDATE songs
            SET album_id = :album_id,
                title = :title,
                cover = :cover,
                release_date = :release_date,
                genre_id = :genre_id,
                mp3_url = :mp3_url,
                video_url = :video_url
            WHERE id = :id
        ");

        return $statement->execute([
            'id' => $id,
            'album_id' => $data['album_id'] ?: null,
            'title' => $data['title'],
            'cover' => $data['cover'] ?: null,
            'release_date' => $data['release_date'] ?: null,
            'genre_id' => $data['genre_id'] ?: null,
            'mp3_url' => $data['mp3_url'] ?: null,
            'video_url' => $data['video_url'] ?: null,
        ]);
    }

    public function delete(int $id): bool
    {
        $statement = self::db()->prepare('DELETE FROM songs WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }

    public function findByAlbum(int $albumId): array
    {
        $statement = self::db()->prepare("
            SELECT s.*, g.name AS genre_name
            FROM songs s
            LEFT JOIN genres g ON g.id = s.genre_id
            WHERE s.album_id = :album_id
            ORDER BY s.release_date DESC, s.id DESC
        ");
        $statement->execute(['album_id' => $albumId]);

        return $statement->fetchAll();
    }
}
