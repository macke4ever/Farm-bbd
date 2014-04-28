<?php 
	session_start();
	include "../../../dbConfig.php";

	if ($_POST['oldpass'] != "" && $_POST['newpass'] != "") {
		$getPass = $db->query("SELECT password FROM users WHERE id = '".$_SESSION["user_id"]."';");

		if (md5($_POST['oldpass']) == $getPass[0]["password"]){
			$db->query("UPDATE users SET `password` = '".md5($_POST['newpass'])."' WHERE id = ".$_SESSION["user_id"].";");
			echo "Slaptažodis pakeistas";
		} else {
			echo "Neteisingas slaptažodis";
		}
	}
 ?>