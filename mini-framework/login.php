<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new User();
    $users = $userModel->getUsers();

    foreach ($users as $user) {
        if ($user['username'] === $_POST['username'] && $user['password'] === $_POST['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: index.php");
            exit();
        }
    }

    // Store error in session and redirect
    $_SESSION['login_error'] = "Invalid credentials.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #137a7f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #86cecb;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if (isset($_SESSION['login_error'])): ?>
        <p class="error-message"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="text" name="username" class="input-field" placeholder="Username" required><br>
        <input type="password" name="password" class="input-field" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>

    <div class="footer">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

</body>
</html>
