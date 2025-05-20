<?php
require_once '../src/utils/session_helper.php';
require_once '../src/controllers/AuthController.php';

ensure_session_started();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController();
    
    if ($authController->login($_POST['email'], $_POST['password'])) {
        header('Location: /php-web-app/public/user_posts.php');
        exit();
    } else {
        header('Location: /php-web-app/public/signin.php');
        exit();
    }
}

require_once '../src/views/signin_view.php';