<?php
$title = "Posts";

ob_start();
?>

<h1 class="mb-4">Posts feed 📰</h1>

<?php include __DIR__ . '/../partials/messages.php'; ?>

<div class="row g-4">
    <?php foreach ($posts ?? [] as $post): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="text-muted">By: <?= htmlspecialchars($post['username']) ?></h6>
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                </div>
                <div class="card-footer text-end">
                    <?php if (!empty($post['user_id']) && (int)$post['user_id'] === (int)$_SESSION['user_id']) : ?>
                        <a href="/posts/edit?id=<?= $post['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-4">
    <a href="/posts/myPosts" class="btn btn-success me-2">My posts</a>
    <a href="/posts/create" class="btn btn-primary me-2">Create post</a>
    <a href="/logout" class="btn btn-secondary">Logout</a>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
?>