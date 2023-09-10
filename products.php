<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Products</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		.items-grid {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			text-align: center;
		}

		.item {
			width: 100%;
			max-width: 200px;
			margin: 10px;
		}

		.item img {
			max-width: 100%;
			height: auto;
			max-height: 200px;
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<header>
		<?php
		session_start();
		 include 'header.php';
	 ?>
	</header>

	<div class="items-grid">

		<?php
		include "db_conn.php";

		
		$items_per_page = 10;
		$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

		$sql = "SELECT COUNT(*) AS total FROM products";
		$result = $connect->query($sql);
		$row = $result->fetch_assoc();
		$total_items = $row['total'];
		$total_pages = ceil($total_items / $items_per_page);

		$offset = ($current_page - 1) * $items_per_page;

		$sql = "SELECT * FROM products ORDER BY id DESC LIMIT $offset, $items_per_page";
		$result = $connect->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<div class='item'>";
				echo "<a href='product.php?id=".$row["id"]."'>";
				echo "<img src='".$row["image"]."' alt='Product Image'>";
				echo "<h3>".$row["name"]."</h3>";
				echo "<p>Price: ".$row["price"]."$</p>";
				echo "</a>";
				echo "</div>";
			}
		} else {
			echo "<p>No available products.</p>";
		}

		$connect->close();
		?>

	</div>

	<?php include "footer.php"; ?>
</body>
</html>
