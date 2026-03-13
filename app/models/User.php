<?php

require_once __DIR__ . '/../../core/Database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function insertUser(string $username, string $passwordHash): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users(username, password_hash) 
            VALUES(:username, :password_hash)
        ");

        return $stmt->execute([
            ':username' => $username,
            ':password_hash' => $passwordHash
        ]);
    }

    public static function usernameExists(string $username): bool
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() !== false;
    }

    public static function findByUsername(string $username): ?array
    {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT id, username, password_hash 
            FROM users 
            WHERE username = :username
        ");
        $stmt->execute([':username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}
