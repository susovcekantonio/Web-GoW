<?php
session_start();
include "db_conn.php";
include "functions.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header("Location: home.php");
        exit();
    }
} else {
    header("Location: home.php");
    exit();
}

$connect->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .product-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 20px;
        }

	
        .product-image {
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            max-height: 500px;
        }

        .product-info {
			
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .product-info h2 {
            margin: 0;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .product-info p {

            margin: 0;
            font-size: 20px;
            line-height: 1.5;
        }

        .product-info label {
            font-weight: bold;
			
            font-size: 16px;
        }

        .product-info input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        .product-info button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .product-info a {
            color: #333;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }



		@media screen and (max-width: 767px) {
            .product-details {
                grid-template-columns: 1fr;
            }

            .product-image {
                text-align: center;
            }

            .product-info {
                text-align: center;
            }

            .product-info h2 {
                margin-top: 0;
            }
        }

        @media screen and (min-width: 768px) {
            .product-details {
                grid-template-columns: 1fr 1fr;
            }

            .product-image {
                text-align: left;
            }

            .product-info {
                text-align: left;
            }

            .product-info h2 {
                margin-top: 0;
            }
        }

        
    </style>
    <script>
        function showAlert() {
            alert('Product added to cart');
        }
    </script>
</head>
<body>
    <header>
		<?php include 'header.php'; ?>

	</div>
    </header>

    <div class="container">
        <div class="product-details">
            <div class="product-image">
                <img src="<?php echo $product['image']; ?>" alt="Product Image">
            </div>
            <div class="product-info">
                <h1><?php echo $product['name']; ?></h1>
                <p><?php echo $product['description']; ?></p>
                <p>Price: <?php echo $product['price']; ?></p>

                <form action="product.php?id=<?php echo $product['id']; ?>" method="POST">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">

                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">

                    <button type="submit" name="add_to_cart" onclick="showAlert()">Add to Cart</button>
                </form>

            </div>
        </div>

        <div class="message"></div>
    </div>

    <footer>
		<?php include 'footer.php'; ?>
        </div>
    </footer>

</body>
</html>
