<?php
require_once '../src/utils/session_helper.php';
$username = check_user_login();

require_once '../src/controllers/PostController.php';

$postController = new PostController();

$userId = $_SESSION['user_id'];
$userPosts = $postController->getUserPosts($userId);

require_once '../src/views/user_posts_view.php';
?>