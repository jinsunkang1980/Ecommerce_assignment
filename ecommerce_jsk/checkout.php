<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/header.php';
include 'includes/db.php';

// Ensure the user is logged in
if (!isset($_COOKIE['user_id'])) {
    echo "<p>Please <a href='login.php'>login</a> to proceed with checkout.</p>";
    include 'includes/footer.php';
    exit();
}

$user_id = $_COOKIE['user_id'];

// Process the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Fetch cart items
    $stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?");
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        die("Error fetching cart data: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $total_price = 0;
        $order_items = [];

        while ($row = $result->fetch_assoc()) {
            $total_price += $row['price'] * $row['quantity'];
            $order_items[] = [
                'product_id' => $row['product_id'],
                'quantity' => $row['quantity']
            ];
        }

        echo "Total Price: $total_price<br>";

        $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total, created_at) VALUES (?, ?, NOW())");
        $order_stmt->bind_param("id", $user_id, $total_price);
        if (!$order_stmt->execute()) {
            die("Error inserting order: " . $order_stmt->error);
        }
        $order_id = $order_stmt->insert_id;
        echo "Order ID: $order_id<br>";

        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        foreach ($order_items as $item) {
            $item_stmt->bind_param("iii", $order_id, $item['product_id'], $item['quantity']);
            if (!$item_stmt->execute()) {
                die("Error inserting order item: " . $item_stmt->error);
            }
        }

        $clear_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clear_stmt->bind_param("i", $user_id);
        if (!$clear_stmt->execute()) {
            die("Error clearing cart: " . $clear_stmt->error);
        }

        header("Location: order_success.php?order_id=$order_id");
        exit();
    } else {
        echo "<p>Your cart is empty. <a href='products.php'>Shop now</a>.</p>";
    }

}

// Display the checkout form
echo "<h1>Checkout</h1>";
echo "<form method='POST' action='checkout.php'>";
echo "<p>Click the button below to confirm your order.</p>";
echo "<button type='submit'>Confirm Order</button>";
echo "</form>";

include 'includes/footer.php';
?>