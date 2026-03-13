<?php
$title = "Create post";

ob_start();
?>

<h1 class="mb-4">Create a new post ✍️</h1>

<form action="/posts/store" method="POST" class="mt-4">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">

    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" name="title" id="title"
            class="form-control"
            placeholder="Your title"
            value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea name="content" id="content" class="form-control" rows="5" placeholder="Write something..."><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Publish</button>
</form>

<div class="mt-4">
    <a href="/posts" class="btn btn-secondary me-2">Back to posts</a>
    <a href="/posts/myPosts" class="btn btn-info text-white">My posts</a>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
