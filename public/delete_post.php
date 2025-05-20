<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

require_once '../src/controllers/PostController.php';
$postController = new PostController();

$postId = $_GET['id'] ?? null;

if ($postId) {
    // Verify the post belongs to current user
    $post = $postController->getPost($postId);
    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        if ($postController->deletePost($postId)) {
            header('Location: user_posts.php');
            exit;
        }
    }
}

// If anything fails, redirect back to posts
header('Location: user_posts.php');
exit;