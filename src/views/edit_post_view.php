<?php
    require_once __DIR__ . '/../utils/session_helper.php';
    $username = check_user_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="/php-web-app/public/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Post</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="/php-web-app/public/edit_post.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <?php if (!empty($post['image_path'])): ?>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Current image" style="max-width: 200px;">
                        <label>
                            <input type="checkbox" name="remove_image"> Remove current image
                        </label>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit">Update Post</button>
            <a href="user_posts.php" class="btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>