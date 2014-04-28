<?php 
session_start();
	include "../../../dbConfig.php";
	if ($_POST['farm'] != "" && $_POST['adress'] != "") {
		$db->query("UPDATE farms SET `name` = '".$_POST['farm']."', adress = '".$_POST['adress']."' WHERE id = ".$_SESSION["user_farm"].";");
	}
 ?>