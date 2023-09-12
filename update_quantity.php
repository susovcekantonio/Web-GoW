<?php
session_start();

include "functions.php";

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $newQuantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = $newQuantity;
    }

    // Calculate the updated total price
    $subtotals = [];
    $totalPrice = 0;

    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = getProductDetails($productId);
        $subtotal = $product['price'] * $quantity;
        $subtotals[$productId] = $subtotal;
        $totalPrice += $subtotal;
    }

    // Return the updated total price as a JSON response
    $response = ['updatedTotalPrice' => $totalPrice];
    echo json_encode($response);
}
?>
