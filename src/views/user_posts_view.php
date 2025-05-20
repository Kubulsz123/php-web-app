<?php
    require_once __DIR__ . '/../utils/session_helper.php';
    $username = check_user_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Posts</title>
    <link rel="stylesheet" href="/php-web-app/public/styles.css">
</head>
<body>
    <header>
        <h1>Your Posts</h1>
        <nav>
            <a href="add_post.php" class="btn">Add New Post</a>
            <a href="search.php" class="btn">Search Posts</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </nav>
    </header>
    <main>
        <?php if (!empty($userPosts)): ?>
            <div class="posts-container">
                <?php foreach ($userPosts as $post): ?>
                    <div class="post">
                        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p><?php echo htmlspecialchars($post['content']); ?></p>
                        <?php if (isset($post['image_path']) && $post['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post image">
                        <?php endif; ?>
                        <div class="post-actions">
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn edit">Edit</a>
                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" 
                               class="btn delete" 
                               onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-posts">No posts found. Start by adding a new post!</p>
        <?php endif; ?>
    </main>
</body>
</html>