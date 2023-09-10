<?php

$totalQuantity=0;

if (isset($_SESSION['cart'])) {
    $totalQuantity = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>God of War Shop</title>
    <style>
        body {
            padding-bottom: 20px;
        }
        
        .header {
            background-color: red;
            padding: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: white;
            text-align: center;
        }

        .header .navigation {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .header .navigation a {
            color: white;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border: 1px solid white;
            border-radius: 5px;
            transition: color 0.3s, transform 0.3s;
        }
        
        .header .navigation a:hover{
            color: #ff6600; 
            transform: scale(1.05);
        }

        .header .navigation a.cart-icon {
            position: relative;
        }
        
        .header .navigation a.cart-icon span {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: pink;
            color: white;
            font-size: 12px;
            font-weight: bold;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header .navigation a.cart-icon i {
            margin-right: 5px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1>God of War Shop</h1>
        <div class="navigation">
        <?php
        if (isset($_SESSION['user_name'])) {  
            echo '<a>' . $_SESSION['user_name'] . '</a>';
            echo '<a href="logout.php">ODJAVA</a>';             
        } else {         
            echo '<a href="login.php">LOGIN</a>';
        }
        ?>
            <a href="products.php">
             ALL PRODUCTS
            </a>
            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                CART
                <?php
                if ($totalQuantity > 0) {
                    echo "<span>$totalQuantity</span>";
                }
                ?>
            </a>
        </div>
    </div>
</body>
</html>
