<?php 
	include_once "../../../dbConfig.php";
	
	if ($_POST['name'] != "") {
		$number = str_replace(',', '.', @$_POST['quantity']);
		$db->query = mysql_query("INSERT INTO `seeds`(`name`, `culture_id`, `farm_id`, `quantity`)  VALUES ('".@$_POST['name']."', '".@$_POST['culture_id']."', ".$_SESSION["user_farm"].", '".@$number."')");
 	}
 ?>