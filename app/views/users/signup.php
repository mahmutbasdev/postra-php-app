<?php
$title = "Sign up";

ob_start();
?>

<h1>Join us 👋</h1>

<form action="/signup" method="POST" class="mt-4">
    <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username"
            class="form-control"
            value="<?= htmlspecialchars($_POST['username'] ?? $username ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Create account</button>
</form>

<p class="mt-3">
    Already have an account? <a href="/login">Login</a>
</p>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
