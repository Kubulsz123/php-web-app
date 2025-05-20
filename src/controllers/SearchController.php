<?php
require_once __DIR__ . '/../models/Post.php';

class SearchController {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function search($query) {
        if (empty($query)) {
            return [];
        }
        return $this->postModel->searchPosts($query);
    }
}