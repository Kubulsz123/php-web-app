<?php
require_once __DIR__ . '/../utils/session_helper.php';
$username = check_user_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Posts</title>
    <link rel="stylesheet" href="/php-web-app/public/styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <h1>Blog App</h1>
            </div>
            <div class="nav-user">
                <span class="username">Welcome, <?php echo htmlspecialchars($username); ?></span>
                <a href="/php-web-app/public/user_posts.php" class="btn">My Posts</a>
                <a href="/php-web-app/public/logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="search-container">
            <form action="/php-web-app/public/search.php" method="GET" class="search-form">
                <input type="text" 
                       name="q" 
                       class="search-input" 
                       placeholder="Search posts..."
                       value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit" class="search-button">Search</button>
            </form>

            <div class="search-results">
                <?php if (empty($query)): ?>
                    <div class="no-results">Enter a search term to find posts</div>
                <?php elseif (empty($results)): ?>
                    <div class="no-results">No posts found matching "<?php echo htmlspecialchars($query); ?>"</div>
                <?php else: ?>
                    <?php foreach ($results as $post): ?>
                        <article class="search-result-item">
                            <?php if (!empty($post['image_path'])): ?>
                                <img class="search-result-image" 
                                     src="<?php echo htmlspecialchars($post['image_path']); ?>" 
                                     alt="Post image">
                            <?php endif; ?>
                            <div class="search-result-content">
                                <h3 class="search-result-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p class="search-result-excerpt">
                                    <?php echo htmlspecialchars(substr($post['content'], 0, 150)) . '...'; ?>
                                </p>
                                <div class="search-result-meta">
                                    Posted by <?php echo htmlspecialchars($post['username']); ?>
                                    on <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>