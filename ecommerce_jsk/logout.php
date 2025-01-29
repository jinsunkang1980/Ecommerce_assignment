<?php
// Start session (optional)
session_start();

// Unset all cookies by setting their expiration time to the past
setcookie('user_id', '', time() - 3600, '/');
setcookie('user_name', '', time() - 3600, '/');

// Redirect user to login page
header("Location: login.php");
exit();
?>
