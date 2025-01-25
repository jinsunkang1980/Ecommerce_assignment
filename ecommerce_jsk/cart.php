<?php
include 'includes/header.php';
include 'includes/db.php';

// Start session for managing user-specific cart
if (!isset($_COOKIE['user_id'])) {
    echo "<p>Please <a href='login.php'>login</a> to access your cart.</p>";
    include 'includes/footer.php';
    exit();
}

$user_id = $_COOKIE['user_id'];

// Add item to cart
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If product already in cart, increase quantity
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $updateStmt->bind_param("ii", $user_id, $product_id);
        $updateStmt->execute();
    } else {
        // Add new product to cart
        $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insertStmt->bind_param("ii", $user_id, $product_id);
        $insertStmt->execute();
    }
    header("Location: cart.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Display the cart
echo "<h1>Your Cart</h1>";

$stmt = $conn->prepare("SELECT c.id AS cart_id, p.id AS product_id, p.name, p.description, p.price, p.image, c.quantity 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $total_price = 0;
    while ($row = $result->fetch_assoc()) {
        $total_item_price = $row['price'] * $row['quantity'];
        $total_price += $total_item_price;
        ?>
        <div class="cart-item">
            <?php echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">' ?>;

            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <p>Price: $<?php echo $row['price']; ?></p>
            <p>Quantity: <?php echo $row['quantity']; ?></p>
            <p>Total: $<?php echo number_format($total_item_price, 2); ?></p>
            <a href="cart.php?remove=<?php echo $row['cart_id']; ?>">Remove</a>
        </div>
        <hr>
        <?php
    }
    ?>
    <h2>Total Price: $<?php echo number_format($total_price, 2); ?></h2>
    <a href="checkout.php" class="button">Proceed to Checkout</a>
    <?php
} else {
    echo "<p>Your cart is empty. <a href='products.php'>Shop now</a>.</p>";
}

include 'includes/footer.php';
?>