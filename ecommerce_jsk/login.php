<?php
// Include database connection
include 'includes/db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare the SQL statement to fetch user details securely
    $stmt = $conn->prepare("SELECT id, password, name FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email); // Bind the email to prevent SQL injection
        $stmt->execute();
        $stmt->store_result();

        // Check if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_password, $user_name);
            $stmt->fetch();
            
            // Verify the entered password using password_verify
            if (password_verify($password, $db_password)) {
                // Set cookies with a 7-day expiry
                setcookie('user_id', $user_id, time() + (86400 * 7), '/');
                setcookie('user_name', $user_name, time() + (86400 * 7), '/');
                
                // Redirect to the homepage
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No user found with this email.";
        }

        $stmt->close();
    } else {
        $error_message = "Database error. Please try again.";
    }
}

// Display any error messages
if (!empty($error_message)) {
    echo "<p style='color: red; text-align: center;'>$error_message</p>";
}
?>

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

<!-- Login Form -->
<form method="POST" action="" style="width: 300px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1);">
    <label for="email">Username or Email Address</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc;">
    
    <label for="password">Password</label>
    <div style="position: relative;">
        <input type="password" id="password" name="password" placeholder="Enter your password" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        <span onclick="togglePasswordVisibility()" style="position: absolute; right: 10px; top: 10px; cursor: pointer;">👁️</span>
    </div>
    
    <div style="margin: 10px 0;">
        <input type="checkbox" id="remember_me" name="remember_me">
        <label for="remember_me"> Remember Me</label>
    </div>
    
    <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Log In</button>
    <p style="text-align: center; margin-top: 10px;"><a href="#">Lost your password?</a></p>
</form>

<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
