<?php
session_start();

include "functions.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Your cart is empty.</h2>";
    echo '<a href="products.php">Go back to Home Page</a>';
    exit();
}

$subtotals = array();
$totalPrice = 0;

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product = getProductDetails($productId);

    $subtotal = $product['price'] * $quantity;
    $subtotals[$productId] = $subtotal;

    // Calculate total price
    $totalPrice += $subtotal;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .order-items {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            padding-left: 20px;
        }

        .order-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            margin-left: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 10%;
        }

        .order-item h2 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .order-item img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .order-item p {
            margin: 5px 0;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .place-order {
            margin-top: 10px;
            padding-bottom: 30px;
            margin-bottom: 10px;
        }

        .go-back {
            margin-top: 10px;
        }

        .order-form {
            margin-top: 20px;
            margin-left: 20px;
            width:10%;
        }

        .order-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .order-form input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var surname = document.getElementById("surname").value;
            var email = document.getElementById("email").value;
            var address = document.getElementById("address").value;

            if (name === "" || surname === "" || email === "" || address === "") {
                alert("Please input all text fields");
                return false;
            }
        }

     
    document.addEventListener('DOMContentLoaded', function () {
        const orderForm = document.getElementById('order-form');
        orderForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting traditionally

            // Collect form data into a JavaScript object
            const formData = {
                name: document.getElementById('name').value,
                surname: document.getElementById('surname').value,
                email: document.getElementById('email').value,
                address: document.getElementById('address').value,
                card: document.getElementById('card').value,
                cartItems: <?php echo json_encode($_SESSION['cart']); ?> // Serialize the cart data as JSON
            };

            // Send the data to the server using AJAX
            fetch('place_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                // Handle the server's response (e.g., show a success message)
                console.log(data);
                // You can redirect the user or display a success message here
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    </script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <p class="total-price">ORDER CONFIRMATION</p>
    <p class="total-price">Total Price: $<?php echo $totalPrice; ?></p>
    <div class="order-items">

        <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
            <?php $product = getProductDetails($productId); ?>
            <div class="order-item">
                <h2><?php echo $product['name']; ?></h2>
                <img src="<?php echo $product['image']; ?>" alt="Product Image">
                <p>Quantity: <?php echo $quantity; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <p>Subtotal: $<?php echo $subtotals[$productId]; ?></p>
            </div>
        <?php endforeach; ?>     

        <div class="order-form">
            <form action="place_order.php" method="post" onsubmit="return validateForm();">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" required>

                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>

				<label for="address">Credit card number</label>

                <input type="text" id="card" name="card" required>

                <input type="submit" name="place_order" value="Place Order">
            </form>
        </div>

       

    </div>
    <?php include "footer.php"; ?>
</body>
</html>
