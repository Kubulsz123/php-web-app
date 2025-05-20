<?php
// src/utils/Helpers.php

class Helpers {
    public static function sanitizeInput($data) {
        return htmlspecialchars(strip_tags($data));
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function redirect($url) {
        header("Location: $url");
        exit();
    }

    public static function flashMessage($message) {
        $_SESSION['flash_message'] = $message;
    }

    public static function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
}
?>