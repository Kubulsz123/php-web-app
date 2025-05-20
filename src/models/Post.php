<?php
require_once __DIR__ . '/../utils/Database.php';

class Post {
    private $conn;

    public function __construct() {
        $this->conn = Database::get();
    }

    public function create($userId, $title, $content, $imagePath = null) {
        try {
            $sql = "INSERT INTO posts (user_id, title, content, image_path) VALUES (:user_id, :title, :content, :image_path)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image_path', $imagePath);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error saving post: " . $e->getMessage();
            return false;
        }
    }

    public function getByUserId($userId) {
        try {
            $sql = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function search($query) {
        // echo "<pre>SEARCH CALLED with query: $query</pre>";
        try {
            $sql = "SELECT * FROM posts WHERE title LIKE :query OR content LIKE :query ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $searchTerm = '%' . $query . '%';
            $stmt->bindParam(':query', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Search error: " . $e->getMessage();
            return [];
        }
    }

    public function searchPosts($query) {
        try {
            $searchQuery = '%' . $query . '%';
            $sql = "SELECT posts.*, users.username 
                    FROM posts 
                    JOIN users ON posts.user_id = users.id 
                    WHERE title LIKE :query 
                    OR content LIKE :query 
                    ORDER BY created_at DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':query', $searchQuery);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function update($id, $data) {
        try {
            $currentPost = $this->getPost($id);
            $imagePath = $currentPost['image_path'];

            // Handle image upload or removal
            if (isset($data['remove_image']) && $data['remove_image']) {
                // Remove existing image file
                if ($imagePath && file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $imagePath);
                }
                $imagePath = null;
            } elseif (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
                // Create uploads directory if it doesn't exist
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/php-web-app/public/uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generate unique filename
                $fileName = uniqid() . '_' . basename($data['image']['name']);
                $uploadPath = $uploadDir . $fileName;
                
                // Upload new image
                if (move_uploaded_file($data['image']['tmp_name'], $uploadPath)) {
                    // Remove old image if exists
                    if ($imagePath && file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $imagePath);
                    }
                    // Set new image path relative to web root
                    $imagePath = '/php-web-app/public/uploads/' . $fileName;
                } else {
                    error_log("Failed to move uploaded file to: " . $uploadPath);
                    throw new Exception("Failed to upload image");
                }
            }

            $sql = "UPDATE posts SET title = :title, content = :content, image_path = :image_path, 
                    updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':image_path', $imagePath);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating post: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM posts WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPost($id) {
        try {
            $sql = "SELECT * FROM posts WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>