<?php

class DashboardController
{
    public function index()
    {
        require_once __DIR__ . '/../../helpers/auth.php';

        $userId = requireAuth();

        include __DIR__ . '/../views/users/dashboard.php';
    }
}
