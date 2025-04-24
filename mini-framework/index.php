<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Blog;

$blogModel = new Blog();
$blogs = isset($_SESSION['user_id']) 
    ? $blogModel->getBlogsByUser($_SESSION['user_id']) 
    : $blogModel->getAllBlogs();

$editingBlog = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $editingBlog = $blogModel->getBlogById($_GET['edit']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_blog'])) {
    $blogModel->updateBlog($_POST['id'], $_POST['title'], $_POST['content']);
    header("Location: index.php");
    exit;
}
    
if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
    $blogModel->deleteBlog($_GET['delete'], $_SESSION['user_id']);
    header("Location: index.php");
    exit();
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blogs</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }
        header {
            background-color: #86cecb;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 28px;
        }
        .btn {
            background-color: #137a7f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #86cecb;
        }
        .blog-post {
            background: white;
            padding: 36px;
            border-radius: 4px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .blog-post:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 6  px;
            margin-top: 0.5px;
        }
        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }
        .author {
            font-size: 14px;
            color: #888;
        }
        header div {
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        header div a {
            margin-left: 10px;
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 40px;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<header>
    <h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?= htmlspecialchars($_SESSION['first_name']) ?>'s Blogs
        <?php else: ?>
            Blogs
        <?php endif; ?>
    </h1>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php" class="btn">Login</a>
    <?php else: ?>
        <div>
            Welcome, <?= $_SESSION['username'] ?> |
            <a href="logout.php" class="btn">Logout</a>
            
        </div>
    <?php endif; ?>
</header>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="blog-post" style="text-align: right;">
        <a href="add_blog.php" class="btn">Add Blog Entry</a>
    </div>
<?php endif; ?>


<?php if (isset($_GET['edit'])): 
    $editingBlog = $blogModel->getBlogById($_GET['edit']); ?>
    <div class="blog-post">
        <h2>Edit Blog</h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="id" value="<?= $editingBlog['id'] ?>">
            <div>
                <input type="text" name="title" value="<?= htmlspecialchars($editingBlog['title']) ?>" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
            </div>
            <div>
                <textarea name="content" rows="6" required style="width: 100%; padding: 8px;"><?= htmlspecialchars($editingBlog['content']) ?></textarea>
            </div>
            <div style="margin-top: 10px;">
                <input type="submit" name="update_blog" value="Update Blog" class="btn">
                <a href="index.php" class="btn">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>


<?php foreach ($blogs as $blog): ?>
    <div class="blog-post">
        <h2>
            <?= htmlspecialchars($blog['title']) ?>
        </h2>
        <p><?= nl2br(htmlspecialchars($blog['content'])) ?></p>
        <small>
            <?php if (!isset($_SESSION['user_id'])): ?>
                By <?= htmlspecialchars($blog['username'] ?? 'Unknown') ?> |
            <?php endif; ?>
            Posted on <?= date('F j, Y, g:i a', strtotime($blog['created_at'])) ?>
        </small>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['author_id']): ?>
            <div style="margin-top: 24px;">
                <a href="index.php?edit=<?= $blog['id'] ?>" class="btn">Edit</a>
                <a href="index.php?delete=<?= $blog['id'] ?>" class="btn" 
   onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>



</body>
</html>
