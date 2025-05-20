<?php
    require_once __DIR__ . '/../utils/session_helper.php';
    $username = check_user_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="/php-web-app/public/styles.css">
</head>
<body>
    <div class="container add-post-container">
        <h2>Add a New Post</h2>
        <form action="/php-web-app/public/add_post.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <div class="image-preview" id="imagePreview"></div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn">Add Post</button>
                <a href="/php-web-app/public/index.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>