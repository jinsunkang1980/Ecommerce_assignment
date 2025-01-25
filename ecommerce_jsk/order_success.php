<?php
include 'includes/header.php';
include 'includes/db.php';

if (!isset($_COOKIE['user_id']) || !isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = intval($_GET['order_id']);
$user_id = $_COOKIE['user_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT total as total_price, created_at as order_date FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    echo "<h1>Order Success</h1>";
    echo "<p>Your order has been placed successfully!</p>";
    echo "<p>Order ID: $order_id</p>";
    echo "<p>Total Price: $" . number_format($order['total_price'], 2) . "</p>";
    echo "<p>Order Date: " . $order['order_date'] . "</p>";
    echo "<a href='index.php'>Return to Home</a>";
} else {
    echo "<p>Invalid order. <a href='index.php'>Return to Home</a>.</p>";
}

include 'includes/footer.php';
?>