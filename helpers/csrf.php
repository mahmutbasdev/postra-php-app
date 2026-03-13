<?php

function generateCSRF(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validateCSRF(string $token): array
{
    if (
        empty($_SESSION['csrf_token']) ||
        empty($token) ||
        !hash_equals($_SESSION['csrf_token'], $token)
    ) {
        return ['Ongeldig CSRF-token.'];
    }

    return [];
}

function regenerateCSRF(): void
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
