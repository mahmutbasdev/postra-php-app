<?php

$title = "Home";

ob_start();
?>

<h1 class="mb-3">Hey 👋</h1>

<h2 class="mb-4">
    This is a platform where I build and learn. Users can register, log in, and create posts.
    Built with PHP, following the MVC pattern, and styled with Bootstrap.
</h2>

<p>
    <a href="/signup" class="btn btn-primary me-2">Create an account</a>
    <a href="/login" class="btn btn-secondary">Login</a>
</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
