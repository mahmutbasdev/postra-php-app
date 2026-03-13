<?php

$title = "Dashboard";

ob_start();
?>

<h1 class="mb-3">You're logged in 👋</h1>
<h2 class="mb-4">Welcome to your dashboard</h2>

<p>
    <a href="/posts" class="btn btn-primary me-2">Go to posts</a>
    <a href="/logout" class="btn btn-danger">Logout</a>
</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
