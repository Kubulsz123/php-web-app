<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

require_once '../src/controllers/PostController.php';
$postController = new PostController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'image' => $_FILES['image'] ?? null,
        'remove_image' => isset($_POST['remove_image'])
    ];
    
    if ($postController->editPost($postId, $data)) {
        header('Location: user_posts.php');
        exit;
    } else {
        $error = "Failed to update post";
    }
} elseif (isset($_GET['id'])) {
    $post = $postController->getPost($_GET['id']);
    if (!$post || $post['user_id'] != $_SESSION['user_id']) {
        header('Location: user_posts.php');
        exit;
    }
} else {
    header('Location: user_posts.php');
    exit;
}

require_once '../src/views/edit_post_view.php';