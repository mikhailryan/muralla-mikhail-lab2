<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Blog;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$blogModel = new Blog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blogModel->createBlog([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'author_id' => $_SESSION['user_id']
    ]);
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            padding: 40px;
        }
        .form-container {
            background: white;
            padding: 24px;
            border-radius: 4px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        .btn {
            background: #007BFF;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #86cecb;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Blog Entry</h2>
    <form method="POST" action="add_blog.php">
        <input type="text" name="title" placeholder="Blog Title" required>
        <textarea name="content" placeholder="Blog Content" rows="8" required></textarea>
        <button type="submit" class="btn">Submit</button>
    </form>
</div>

</body>
</html>
