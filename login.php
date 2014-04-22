<?php
	session_start();

	$message="";

	if(count($_POST)>0) {
		$conn = mysql_connect("pjauk.lt","farm","belarus");
		mysql_select_db("farm",$conn);
		// $q = "SELECT * FROM users WHERE username='".$_POST["username"]."' and password = '".md5($_POST["password"])."'";
		// var_dump($q);
		$uname = str_replace(",\"", "''\"\"", $_POST["username"]);
		$result = mysql_query("SELECT * FROM users WHERE username='".$uname."' and password = '".md5($_POST["password"])."'");
		$row  = mysql_fetch_array($result);
		if(is_array($row)) {
			$_SESSION["user_id"] = $row['id'];
			$_SESSION["user_name"] = $row['username'];
			$_SESSION["user_rights"] = $row['rights'];
			$_SESSION["user_farm"] = $row['farm_id'];
			$_SESSION["user_season"] = $row['lastSeason'];
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
