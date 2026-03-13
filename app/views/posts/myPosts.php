<?php
$title = "My posts";

ob_start();
?>

<h1 class="mb-4">My posts 📝</h1>

<?php if (!empty($posts)) : ?>
    <div class="row g-4">
        <?php foreach ($posts as $post) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="/posts/edit?id=<?= $post['id'] ?>" class="btn btn-sm btn-primary me-2">Edit</a>

                        <form method="POST" action="/posts/delete" class="d-inline">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>No posts yet. Start creating something!</p>
<?php endif; ?>

<div class="mt-4">
    <a href="/posts/create" class="btn btn-success me-2">Create new post</a>
    <a href="/posts" class="btn btn-secondary">Back to posts</a>
</div>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/main.php';
