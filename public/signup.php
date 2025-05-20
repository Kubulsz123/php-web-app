<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../src/utils/session_helper.php';
require_once '../src/controllers/AuthController.php';

ensure_session_started();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController();
    
    if ($authController->register($_POST)) {
        header('Location: signin.php');
        exit();
    } else {
        // Redirect back to signup form with error message
        header('Location: signup.php');
        exit();
    }
}

// Show signup form
require_once '../src/views/signup_view.php';
