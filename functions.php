<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getProductDetails($productId)
{
    include "db_conn.php";

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $connect->close();
        return $product;
    } else {
        return array();
    }
}

// Add to Cart functionality
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        // If the product already exists in the cart, update the quantity
        $_SESSION['cart'][$productId] = $quantity;
    } else {
        // If the product does not exist in the cart, add it with the quantity
        $_SESSION['cart'][$productId] = $quantity;
    }

    echo "<script>alert('Product added to cart');</script>";

    header("Location: cart.php");
    exit();
}

// Remove from Cart functionality
if (isset($_GET['remove']) && isset($_GET['id'])) {
    $productId = $_GET['id'];

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}

if (isset($_POST['update_quantity']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = $quantity;
    }
    header("Location: cart.php");
    exit();
}
?>
