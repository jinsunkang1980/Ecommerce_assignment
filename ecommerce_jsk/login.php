<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch user details
    $stmt = $conn->prepare("SELECT id, password, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // Use email only for the query to prevent SQL injection
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $db_password, $user_name);
        $stmt->fetch();
        
        // Directly compare the entered password with the stored password (not recommended)
        // if ($password === $db_password) {
        if(password_verify($password, $db_password)) {
            // Set the user_id cookie for 7 days
            setcookie('user_id', $user_id, time() + (86400 * 7), '/');
            setcookie('user_name', $user_name, time() + (86400 * 7), '/');
            
            header("Location: index.php"); // Redirect to homepage after login
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }

    $stmt->close();
}
?>
<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>