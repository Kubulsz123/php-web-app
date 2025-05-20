<?php
    // filepath: php-web-app/php-web-app/public/search.php

    // echo "<pre>POST:";
    // print_r($_POST);
    // echo "</pre>";
    // echo "LOADED SEARCH.PHP<br>";

    require_once '../src/utils/session_helper.php';
    require_once '../src/controllers/SearchController.php';

    ensure_session_started();
    $username = check_user_login();

    $searchController = new SearchController();
    $query = $_GET['q'] ?? '';
    $results = $searchController->search($query);

    require_once '../src/views/search_view.php';

    // $postModel = new Post();
    // $searchController = new SearchController($postModel);
    // print_r($searchController->searchPosts("ski")); // <<-- ręczne odpalenie

?>