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

            // Check if the cart is empty
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<h2>Your cart is empty.</h2>";
                echo '<a href="products.php">Go back to Home Page</a>';
                exit();
            }

            // Clear the cart
            $_SESSION['cart'] = array();

            echo "<h2>Order placed successfully! Thank you for shopping with us!</h2>";
            echo '<a href="products.php">Go back to Home Page</a>';
            ?>
        </div>
    </div>
</body>
</html>
