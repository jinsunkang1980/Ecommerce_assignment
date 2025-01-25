<?php
include 'includes/header.php';
include 'includes/db.php';

$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()):
?>
    <div class="product">
        <?php echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">' ?>;
        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <p>$<?php echo $row['price']; ?></p>
        <a href="cart.php?add=<?php echo $row['id']; ?>" style="display: inline-block; width: 150px; height: 40px; text-align: center; line-height: 40px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Add to Cart</a>
        </div>
<?php endwhile; ?>
<?php include 'includes/footer.php'; ?>