<?php
$title = "Edit post";

ob_start();
?>

<h1 class="mb-4">Edit post ✏️</h1>

<form method="POST" action="/posts/update" class="mt-4">
    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" name="title" id="title" class="form-control"
            value="<?= htmlspecialchars($_POST['title'] ?? $post['title']) ?>">
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea name="content" id="content" class="form-control" rows="5"><?= htmlspecialchars($_POST['content'] ?? $post['content']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save changes</button>
</form>

<div class="mt-4">
    <a href="/posts/create" class="btn btn-success me-2">Create new post</a>
    <a href="/posts" class="btn btn-secondary">Back to posts</a>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
