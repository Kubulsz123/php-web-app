<?php
require_once __DIR__ . '/../models/Post.php';

class PostController {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function savePost($userId, $title, $content, $image) {
        $imagePath = null;

        // Handle image upload
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $imagePath = $uploadDir . basename($image['name']);
            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                echo "Failed to upload image.";
                return false;
            }
        }

        return $this->postModel->create($userId, $title, $content, $imagePath);
    }

    public function editPost($id, $data) {
        // Verify post exists and belongs to user
        $post = $this->getPost($id);
        if (!$post || $post['user_id'] != $_SESSION['user_id']) {
            return false;
        }
        
        return $this->postModel->update($id, $data);
    }

    public function deletePost($id) {
        // Logic to delete a post
        return $this->postModel->delete($id);
    }

    public function getUserPosts($userId) {
        // Logic to retrieve posts for a specific user
        return $this->postModel->getByUserId($userId);
    }

    public function getPost($id) {
        // Get a single post by ID
        return $this->postModel->getPost($id);
    }
}
?>