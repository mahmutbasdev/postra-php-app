<?php

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/validation.php';
require_once __DIR__ . '/../../helpers/csrf.php';
require_once __DIR__ . '/../../helpers/flash.php';
require_once __DIR__ . '/../models/PostModel.php';

class PostController
{
    private PostModel $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    private function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(403);
            exit;
        }
    }

    private function validateRequest(string $csrfToken, string $title, string $content): array
    {
        return array_merge(
            validateCSRF($csrfToken),
            validatePostData($title, $content)
        );
    }

    private function findOwnedPost(int $postId, int $userId): ?array
    {
        $post = PostModel::getById($postId);
        return ($post && $post['user_id'] === $userId) ? $post : null;
    }

    private function redirectWithErrors(array $errors, string $path): void
    {
        $_SESSION['errors'] = $errors;
        header("Location: $path");
        exit;
    }

    private function redirectWithSuccess(string $message, string $path): void
    {
        addFlash('success', $message);
        header("Location: $path");
        exit;
    }

    private function setNoCacheHeaders(): void
    {
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    public function index()
    {
        $this->setNoCacheHeaders();
        requireAuth();
        $posts = PostModel::getAll();
        $csrfToken = generateCSRF();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        require_once __DIR__ . '/../views/posts/index.php';
    }

    public function create()
    {
        $this->setNoCacheHeaders();
        requireAuth();
        $csrfToken = generateCSRF();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        require_once __DIR__ . '/../views/posts/create.php';
    }

    public function store()
    {
        $this->setNoCacheHeaders();
        $userId = requireAuth();
        $this->requirePost();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $csrfToken = $_POST['csrf_token'] ?? '';

        $errors = $this->validateRequest($csrfToken, $title, $content);

        if (!empty($errors)) {
            $this->redirectWithErrors($errors, "/posts/create");
        }

        $this->postModel->createPost($userId, $title, $content);
        regenerateCSRF();
        $this->redirectWithSuccess('Post succesvol aangemaakt.', '/posts');
    }

    public function myPosts()
    {
        $this->setNoCacheHeaders();
        $userId = requireAuth();
        $posts = PostModel::getByUser($userId);
        $csrfToken = generateCSRF();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        require_once __DIR__ . '/../views/posts/myPosts.php';
    }

    public function edit()
    {
        $this->setNoCacheHeaders();
        $userId = requireAuth();
        $postId = (int)($_GET['id'] ?? 0);

        $post = $this->findOwnedPost($postId, $userId);
        if (!$post) {
            $this->redirectWithErrors(["Geen toegang tot deze post."], "/posts");
        }

        $csrfToken = generateCSRF();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        require_once __DIR__ . '/../views/posts/edit.php';
    }

    public function update()
    {
        $this->setNoCacheHeaders();
        $userId = requireAuth();
        $this->requirePost();

        $postId = (int)($_POST['id'] ?? 0);
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $csrfToken = $_POST['csrf_token'] ?? '';

        $errors = $this->validateRequest($csrfToken, $title, $content);

        $post = $this->findOwnedPost($postId, $userId);
        if (!$post) {
            $errors[] = "Geen toegang tot deze post.";
        }

        if (!empty($errors)) {
            $this->redirectWithErrors($errors, "/posts/edit?id=$postId");
        }

        if (!$this->postModel->update($postId, $title, $content)) {
            $this->redirectWithErrors(["Er is iets misgegaan bij het bijwerken van de post."], "/posts/edit?id=$postId");
        }

        regenerateCSRF();
        $this->redirectWithSuccess("Post is succesvol bijgewerkt.", "/posts/myPosts");
    }

    public function delete()
    {
        $this->setNoCacheHeaders();
        $userId = requireAuth();
        $this->requirePost();

        $postId = (int)($_POST['id'] ?? 0);
        $csrfToken = $_POST['csrf_token'] ?? '';

        $errors = validateCSRF($csrfToken);

        $post = $this->findOwnedPost($postId, $userId);
        if (!$post) {
            $errors[] = "Je mag deze post niet verwijderen.";
        }

        if (!empty($errors)) {
            $this->redirectWithErrors($errors, "/posts/myPosts");
        }

        if ($this->postModel->delete($postId)) {
            regenerateCSRF();
            $this->redirectWithSuccess("Post is succesvol verwijderd.", "/posts/myPosts");
        } else {
            $this->redirectWithErrors(["Er is iets misgegaan bij het verwijderen."], "/posts/myPosts");
        }
    }
}
