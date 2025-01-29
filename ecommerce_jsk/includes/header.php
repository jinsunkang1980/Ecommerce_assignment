<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theos Canada by Jinsun Kang</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
    <div class="nav-left">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
        </div>

        <div class="nav-right">
            <?php if (isset($_COOKIE['user_name'])): ?>
                <span class="username">
                    Hello, <?php echo htmlspecialchars($_COOKIE['user_name']); ?>!
                </span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>


    </nav>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 98%;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }
    </style>

 <!-- Navigation Bar -->
 <div class="navbar">
        <div class="left">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
        </div>
        <div class="right">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>
