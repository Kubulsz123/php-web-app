# PHP Web Application

This is a simple web application built with PHP that allows users to sign up, sign in, create posts, display posts, and search for posts. The application includes user-specific post management features.

## Features

- **User Registration**: Users can create an account by providing their details.
- **User Authentication**: Users can log in to their accounts to access their posts.
- **Post Management**: Users can add new posts, view their posts, and delete or edit them.
- **Search Functionality**: Users can search for posts based on keywords.

## Project Structure

```
php-web-app
├── public
│   ├── index.php          # Entry point for the application
│   ├── signup.php         # User registration page
│   ├── signin.php         # User login page
│   ├── add_post.php       # Page to add new posts
│   ├── search.php         # Page to search for posts
│   └── user_posts.php     # Page to display user's posts
├── src
│   ├── controllers
│   │   ├── AuthController.php  # Handles user authentication
│   │   ├── PostController.php  # Manages posts
│   │   └── SearchController.php # Handles post searching
│   ├── models
│   │   ├── User.php           # User model
│   │   └── Post.php           # Post model
│   ├── views
│   │   ├── signup_view.php     # View for signup page
│   │   ├── signin_view.php     # View for signin page
│   │   ├── add_post_view.php   # View for adding posts
│   │   ├── search_view.php     # View for search results
│   │   └── user_posts_view.php # View for displaying user posts
│   └── utils
│       ├── Database.php        # Database connection and queries
│       └── Helpers.php         # Utility functions
├── config
│   └── config.php             # Configuration settings
├── vendor                      # Composer dependencies
├── composer.json               # Composer configuration file
└── composer.lock               # Locked versions of dependencies
```

## Installation

1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Run `composer install` to install the required dependencies.
4. Configure your database settings in `config/config.php`.
5. Start a local server and navigate to `public/index.php` to access the application.

## Usage

- Visit the signup page to create a new account.
- Log in to your account to manage your posts.
- Use the search feature to find specific posts.
- Add, edit, or delete your posts as needed.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any suggestions or improvements.