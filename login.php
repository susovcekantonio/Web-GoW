<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['k_ime']) && isset($_POST['lozinka'])) {

	function validate($data){
     $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['k_ime']);
	$pass = validate($_POST['lozinka']);

	if (empty($uname)) {
		header("Location: index.php?error=Niste unjeli korisničko ime");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Niste unjeli lozinku");
	    exit();
	}else{
		$sql = "SELECT * FROM korisnici WHERE user_name=?";
		$stmt = $connect->prepare($sql);

		$stmt->bind_param("s", $uname);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_userid, $db_name, $db_username, $db_paswordHASH);

		if ($stmt->num_rows === 1) {
			$stmt->fetch();
			if (password_verify($pass, $db_paswordHASH)) {
				$_SESSION['id'] = $db_userid;
				$_SESSION['user_name'] = $db_username;
				$_SESSION['name'] = $db_name;
				header("Location: products.php");
				exit();
			}else{
				header("Location: index.php?error=Neispravna lozinka");
				exit();
			}
		}else{
			header("Location: index.php?error=Neispravno korisničko ime");
			exit();
		}
		$connect->close();
	}
	
}else{
	header("Location: index.php");
	exit();
}
?>
