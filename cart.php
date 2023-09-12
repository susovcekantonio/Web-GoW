<?php
session_start();

include "functions.php";


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

    echo "<h2>Your cart is empty.</h2>";
    echo '<a href="products.php">Go back to the products and select something!</a>';
    exit();
}


$subtotals = [];
$totalPrice = 0;
$totalQuantity = 0; 

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product = getProductDetails($productId);

    $subtotal = $product['price'] * $quantity;
    $subtotals[$productId] = $subtotal;

    $totalPrice += $subtotal;

    $totalQuantity += $quantity;
}


if (isset($_POST['update_quantity']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = $quantity;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .cart-items {
            display: flex;
            flex-direction: column;
            align-items: left;
            margin-top: 20px;
            padding-left: 30px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item img {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }

        .cart-item-info {
            display: flex;
            flex-direction: column;
        }

        .cart-item-info h2 {
            margin-bottom: 5px;
        }

        .cart-item-info p {
            margin: 0;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
        }

        .cart-item-actions input[type="number"] {
            width: 50px;
            margin-right: 10px;
        }

        .remove-button {
            display: inline-block;
            padding: 5px 10px;
            background-color: #FFDDEE;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-button:hover {
            background-color: #FFC0D0;
        }

        .total-price {
            font-size: 30px;
            font-weight: bold;
            margin-top: 20px;
        }

        .proceed-order {
            margin-top: 10px;
            padding-bottom: 30px;
        }

        .go-back {
            margin-top: 10px;
        }


        @media (max-width: 768px) {
            .cart-items {
                padding-left: 15px;
            }

            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item img {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .cart-item-info {
                order: 1;
                margin-bottom: 10px;
            }

            .cart-item-actions {
                order: 2;
                margin-top: 10px;
                justify-content: flex-start;
            }

            .remove-button {
                padding: 3px 8px;
                font-size: 14px;
            }
        }
    </style>
    
    <script>
    function updateQuantity(productId, newQuantity) {
        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the total price and any other relevant UI elements
                const response = JSON.parse(xhr.responseText);
                const updatedTotalPrice = response.updatedTotalPrice;
                document.querySelector('.total-price').textContent = `Total Price: $${updatedTotalPrice}`;
            }
        };

        // Send the AJAX request
        xhr.open('POST', 'update_quantity.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`product_id=${productId}&quantity=${newQuantity}`);
        
        // Trigger form submission
        const form = document.getElementById(`quantity-form-${productId}`);
        form.submit();
    }
</script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="cart-items">
        <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
            <?php $product = getProductDetails($productId); ?>
            <div class="cart-item">
                <img src="<?php echo $product['image']; ?>" alt="Product Image">
                <div class="cart-item-info">
                    <h2><?php echo $product['name']; ?></h2>
                    <p>Price: $<?php echo $product['price']; ?></p>
                    <p>Quantity: <?php echo $quantity; ?></p>
                    <p>Subtotal: $<?php echo $subtotals[$productId]; ?></p>
                </div>
                <div class="cart-item-actions">
                <form id="quantity-form-<?php echo $productId; ?>" class="cart-quantity-form">
    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
    <input type="number" id="quantity-input-<?php echo $productId; ?>" name="quantity" value="<?php echo $quantity; ?>" oninput="updateQuantity(<?php echo $productId; ?>, this.value)">
    <!-- Hidden submit button -->
    <input type="submit" style="display: none;">
</form>
                    <a href="cart.php?remove=true&id=<?php echo $productId; ?>" class="remove-button">Remove</a>
                </div>
            </div>
        <?php endforeach; ?>

        <p class="total-price">Total Price: $<?php echo $totalPrice; ?></p>

        <form action="order.php" method="post" class="proceed-order">
            <input type="submit" name="proceed_order" value="Proceed with Order">
        </form>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        document.getElementById("cart-icon").textContent = "<?php echo $totalQuantity; ?>";
    </script>
</body>
</html>
