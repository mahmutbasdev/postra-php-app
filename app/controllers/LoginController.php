<?php

require_once __DIR__ . '/../../app/models/User.php';

class LoginController
{
    public function show()
    {
        require_once __DIR__ . '/../views/users/login.php';
    }
 
    public function login()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if (!$username) $errors[] = "Gebruikersnaam is verplicht!";
        if (!$password) $errors[] = "Wachtwoord is verplicht!";

        if ($errors) {
            require_once __DIR__ . '/../views/users/login.php';
            return;
        }

        $user = User::findByUsername($username);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = "Onjuiste login gegevens!";
            require_once __DIR__ . '/../views/users/login.php';
            return;
        }

        if (session_status() === PHP_SESSION_NONE) session_start();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: /dashboard');
        exit;
    }
}
