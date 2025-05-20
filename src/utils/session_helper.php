<?php
function ensure_session_started() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function check_user_login() {
    ensure_session_started();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        header('Location: /php-web-app/public/signin.php');
        exit();
    }
    return $_SESSION['username'];
}