<?php
function requireAuth(): int
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        header("Location: /login");
        exit();
    }

    return $userId;
}
