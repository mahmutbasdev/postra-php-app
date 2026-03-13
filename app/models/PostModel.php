<?php

require_once __DIR__ . '/../../core/Database.php';

class PostModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createPost($userId, $title, $content): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO posts (user_id, title, content)
            VALUES (:user_id, :title, :content)
        ");

        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':content' => $content
        ]);
    }

    public static function getAll(): array
    {
        $db = Database::connect();
        $stmt = $db->query("
        SELECT posts.id, posts.user_id, posts.title, posts.content, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.id DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getByUser(int $userId): array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT id, title, content 
            FROM posts 
            WHERE user_id = :user_id 
            ORDER BY id DESC
        ");
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById(int $postId): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT id, user_id, title, content 
            FROM posts 
            WHERE id = :id
        ");
        $stmt->execute([':id' => $postId]);

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        return $post ?: null;
    }

    public function update(int $postId, string $title, string $content): bool
    {
        $stmt = $this->db->prepare("
            UPDATE posts
            SET title = :title, content = :content
            WHERE id = :id
        ");

        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':id' => $postId
        ]);
    }

    public function delete(int $postId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute([':id' => $postId]);
    }
}
