<?php
// filepath: php-web-app/php-web-app/public/index.php

require_once '../src/utils/Database.php';
require_once '../src/utils/session_helper.php';
require_once '../src/controllers/AuthController.php';
require_once '../src/controllers/PostController.php';
require_once '../src/controllers/SearchController.php';

// Initialize the application
ensure_session_started();

// Get database connection using singleton pattern
$conn = Database::get();

// Routing logic
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/php-web-app/public';
$route = str_replace($basePath, '', $requestUri);

switch ($route) {
    case '/':
    case '/index.php':
        require 'user_posts.php';
        break;
    case '/signup.php':
    case '/signup':
        require 'signup.php';
        break;
    case '/signin.php':
    case '/signin':
        require 'signin.php';
        break;
    case '/add_post.php':
    case '/add_post':
        require 'add_post.php';
        break;
    case '/search.php':
    case '/search':
        require 'search.php';
        break;
    case '/user_posts.php':
    case '/user_posts':
        require 'user_posts.php';
        break;
    default:
        // Handle 404 error or redirect to home
        header('Location: /php-web-app/public/index.php');
        exit();
        break;
}
?>