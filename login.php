<?php
	session_start();

	$message="";

	if(count($_POST)>0) {
		$conn = mysql_connect("localhost","root","root");
		mysql_select_db("lrubik_agro",$conn);
		// $q = "SELECT * FROM users WHERE username='".$_POST["username"]."' and password = '".md5($_POST["password"])."'";
		// var_dump($q);
		$uname = str_replace(",\"", "''\"\"", $_POST["username"]);
		$password = str_replace(",\"", "''\"\"", $_POST["password"]);
		mysql_query("SET CHARACTER SET utf8");
		$result = mysql_query("SELECT * FROM users WHERE username='".$uname."' and password = '".md5($password)."'");
		$row  = mysql_fetch_array($result);
		if(is_array($row)) {
			$_SESSION["user_id"] = $row['id'];
			$_SESSION["user_name"] = $row['username'];
			$_SESSION["user_rights"] = $row['rights'];
			$_SESSION["user_farm"] = $row['farm_id'];
			$_SESSION["user_season"] = $row['lastSeason'];
			$_SESSION["firstname"] = $row['firstname'];
			$_SESSION["lastname"] = $row['lastname'];
			$_SESSION["active"] = true;
		} else {
			$message="Neteisingas prisijungimo vardas arba slaptažodis \n";
		}
	}
	if(isset($_SESSION["user_id"])) {
		header("Location:index.php");
	}
	if ($message != ''){
		header("Location:index.php?message=".$message);
	}
?>
