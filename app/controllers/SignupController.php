<?php

require_once __DIR__ . '/../../app/models/User.php';

class SignupController
{
    public function show()
    {
        require_once __DIR__ . '/../views/users/signup.php';
    }

    public function registerUser()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if (!$username) $errors[] = "Gebruikersnaam is verplicht!";
        if (!$password) $errors[] = "Wachtwoord is verplicht!";

        if ($username) {
            $len = strlen($username);
            if ($len < 3) $errors[] = "Gebruikersnaam moet minimaal 3 tekens bevatten!";
            if ($len > 20) $errors[] = "Gebruikersnaam mag maximaal 20 tekens bevatten!";
            if (User::usernameExists($username)) $errors[] = "Gebruikersnaam bestaat al!";
        }

        if ($password && strlen($password) < 8) $errors[] = "Wachtwoord moet minimaal 8 tekens bevatten!";

        if ($errors) {
            require_once __DIR__ . '/../views/users/signup.php';
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userModel = new User();
        $userModel->insertUser($username, $passwordHash);

        $success = "Gebruiker '" . htmlspecialchars($username) . "' is succesvol geregistreerd!";

        require_once __DIR__ . '/../views/users/login.php';
    }
}
