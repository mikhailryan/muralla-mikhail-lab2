<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new User();
    $userModel->createUser([
        'first_name' => $_POST['first_name'],
        'last_name'  => $_POST['last_name'],
        'username'   => $_POST['username'],
        'password'   => $_POST['password']
    ]);
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
    <h2>Create Account</h2>
    <form method="POST" action="register.php">
        <input type="text" name="first_name" class="input-field" placeholder="First Name" required>
        <input type="text" name="last_name" class="input-field" placeholder="Last Name" required>
        <input type="text" name="username" class="input-field" placeholder="Username" required>
        <input type="password" name="password" class="input-field" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <div class="footer">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>
