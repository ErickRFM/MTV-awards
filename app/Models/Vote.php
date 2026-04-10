<?php

require_once __DIR__ . '/Model.php';

class Vote extends Model
{
    public static function countAll(): int
    {
        return self::countTable('votes');
    }

    public static function create(int $userId, int $nominationId, int $itemId): int
    {
        $statement = self::db()->prepare("
            INSERT INTO votes (user_id, nomination_id, nomination_item_id)
            VALUES (:user_id, :nomination_id, :nomination_item_id)
        ");
        $statement->execute([
            'user_id' => $userId,
            'nomination_id' => $nominationId,
            'nomination_item_id' => $itemId,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function userVoted(int $userId, int $nominationId): bool
    {
        $statement = self::db()->prepare("
            SELECT COUNT(*)
            FROM votes
            WHERE user_id = :user_id AND nomination_id = :nomination_id
        ");
        $statement->execute([
            'user_id' => $userId,
            'nomination_id' => $nominationId,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public static function countByItem(int $itemId): int
    {
        $statement = self::db()->prepare("
            SELECT COUNT(*)
            FROM votes
            WHERE nomination_item_id = :item_id
        ");
        $statement->execute(['item_id' => $itemId]);

        return (int) $statement->fetchColumn();
    }
}
