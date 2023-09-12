<!DOCTYPE html>
<html>
<head>
    <style>
        body {
	        background: #616263;
        }

        .center-box {
            display: flex;
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            text-align: center; 
            height: 100vh;
        }

        .content {
            border: 1px solid #ccc; 
            padding: 20px; 
            background-color: #f0f0f0; 
        }
    </style>
</head>
<body>
    <div class="center-box">
        <div class="content">
            <?php
            session_start();

            include "functions.php";
            include "db_conn.php"; // Include your database connection script

            // Check if the cart is empty
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<h2>Your cart is empty.</h2>";
                echo '<a href="products.php">Go back to Home Page</a>';
                exit();
            }

// Extract order data from the form
$name = mysqli_real_escape_string($connect, $_POST['name']);
$surname = mysqli_real_escape_string($connect, $_POST['surname']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$address = mysqli_real_escape_string($connect, $_POST['address']);
$card = mysqli_real_escape_string($connect, $_POST['card']);

$sql = "INSERT INTO orders (name, surname, email, address, card) 
        VALUES ('$name', '$surname', '$email', '$address', '$card')";

if ($connect->query($sql) === TRUE) {
    // Get the ID of the newly inserted order
    $order_id = $connect->insert_id;

    // Insert cart items into the "order_items" table
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;

        $insertItemSQL = "INSERT INTO order_items (order_id, product_id, quantity) 
                           VALUES ('$order_id', '$product_id', '$quantity')";

        $connect->query($insertItemSQL);
    }

    // Order data and cart items inserted successfully
    echo "<h2>Order placed successfully! Thank you for shopping with us!</h2>";
    echo '<a href="products.php">Go back to Home Page</a>';
} else {
    // Error handling for database insertion failure
    echo "<h2>Error placing the order: " . $connect->error . "</h2>";
    echo '<a href="products.php">Go back to Home Page</a>';
}

// Clear the shopping cart
$_SESSION['cart'] = array();

// Close the database connection
$connect->close();
?>
        </div>
    </div>
</body>
</html>
