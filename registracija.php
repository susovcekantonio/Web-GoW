<!DOCTYPE html>
<html>
<head>
	<title>Naslovna</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		*{
	font-family: sans-serif;
	box-sizing: border-box;
}
body {
	background: #616263;
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
	flex-direction: column;
}
form {
	width: 500px;
	border: 2px solid #ccc;
	padding: 30px;
	background: #fff;
	border-radius: 15px;
}
h2 {
	text-align: center;
	margin-bottom: 40px;
}
input {
	display: block;
	border: 2px solid #ccc;
	width: 95%;
	padding: 10px;
	margin: 10px auto;
	border-radius: 5px;
}
label {
	color: #888;
	font-size: 18px;
	padding: 10px;
}
button {
	float: right;
	background: #555;
	padding: 10px 15px;
	color: #fff;
	border-radius: 5px;
	margin-right: 10px;
	border: none;
}
button:hover{
	opacity: .7;
}
.error {
  background: #F2DEDE;
  color: #A94442;
  padding: 10px;
  width: 95%;
  border-radius: 5px;
  margin: 20px auto;
}
h1 {
	text-align: center;
	color: #fff;
}
a {
	float: right;
	background: #555;
	padding: 10px 15px;
	color: #fff;
	border-radius: 5px;
	margin-top: 10px;
	margin-right: 10px;
	border: none;
	text-decoration: none;
}
a:hover{
	opacity: .7;
}
div a {
	background: #555;
	padding: 10px 15px;
	color: #fff;
	border-radius: 5px;
	border: none;
	text-decoration: none;
	margin-top: 20px
}
table {
	border-collapse: collapse;
	width: 65%;
	background-color:white;
}
th, td {
	padding: 8px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}
tr:hover {
	background-color: #f5f5f5;
}
.edit-btn, .delete-btn {
	padding: 5px 10px;
	border-radius: 4px;
	cursor: pointer;
}
.edit-btn {
	background-color: #4FBDE0;
	color: white;
}
.delete-btn {
	background-color: #f44336;
	color: white;
}
	</style>
</head>
<body>
     <form action="register.php" method="post">
     	<h2>Podaci za registraciju:</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
			<label>Vaše ime</label>
     	<input type="text" name="ime" placeholder="Your Name"><br>

     	<label>Korisničko ime</label>
     	<input type="text" name="k_ime" placeholder="User Name"><br>

     	<label>Lozinka</label>
     	<input type="password" name="lozinka" placeholder="Password"><br>

			<label>Ponovite lozinku</label>
     	<input type="password" name="lozinka2" placeholder="Password one more time"><br>

     	<button type="submit">Registriraj se</button>
     </form>
		 <div>
			<a href="index.php">Prijava</a>
		 </div>

</body>
</html>