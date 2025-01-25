<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
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