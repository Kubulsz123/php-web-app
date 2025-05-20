<?php
// filepath: c:\xampp\htdocs\php-web-app\src\controllers\AuthController.php
require_once __DIR__ . '/../models/User.php';

// echo "Including User.php...<br>";
// if (file_exists(__DIR__ . '/../models/User.php')) {
//     echo "User.php exists.<br>";
// } else {
//     echo "User.php does not exist.<br>";
// }

// if (class_exists('User')) {
//     echo "User class loaded successfully.<br>";
// } else {
//     echo "Failed to load User class.<br>";
// }

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register($data) {
        $result = $this->userModel->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        if (!$result['success']) {
            $_SESSION['error'] = $result['error'];
            $_SESSION['form_data'] = [
                'username' => $data['username'],
                'email' => $data['email']
            ];
            return false;
        }

        return true;
    }

    public function login($email, $password) {
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

        $_SESSION['error'] = 'Invalid email or password';
        return false;
    }

    public function logout() {
        session_destroy();
    }

    public function signup($data) {
        // Hash password before storing
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $result = $this->userModel->create($data);
        
        if (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
            return false;
        }
        
        return true;
    }
}
?>