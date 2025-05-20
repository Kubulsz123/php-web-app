<?php
require_once __DIR__ . '/../utils/Database.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = Database::get();
    }

    public function create($data) {
        try {
            // Check if user already exists
            $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $checkEmailStmt = $this->conn->prepare($checkEmailSql);
            $checkEmailStmt->bindParam(':email', $data['email']);
            $checkEmailStmt->execute();
            
            if ($checkEmailStmt->fetchColumn() > 0) {
                return [
                    'success' => false,
                    'error' => 'This email is already registered'
                ];
            }

            $checkUsernameSql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $checkUsernameStmt = $this->conn->prepare($checkUsernameSql);
            $checkUsernameStmt->bindParam(':username', $data['username']);
            $checkUsernameStmt->execute();

            if ($checkUsernameStmt->fetchColumn() > 0) {
                return [
                    'success' => false,
                    'error' => 'This username is already taken'
                ];
            }

            // Create new user if no duplicates found
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            
            if ($stmt->execute()) {
                return ['success' => true];
            }

            return [
                'success' => false,
                'error' => 'Failed to create user'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => 'Database error occurred'
            ];
        }
    }


    public function authenticate($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>