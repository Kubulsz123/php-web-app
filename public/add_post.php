<?php
session_start();
require_once '../src/controllers/PostController.php';

// Initialize the PostController
$postController = new PostController();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $image = $_FILES['image'] ?? null;

    // Save the post
    $result = $postController->savePost($userId, $title, $content, $image);

    if ($result) {
        echo "Post saved successfully!";
        header('Location: search.php');
        exit;
    } else {
        echo "Failed to save the post.";
    }
}

include '../src/views/add_post_view.php';
?>