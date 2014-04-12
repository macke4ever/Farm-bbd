<?php 
	include "../../../dbConfig.php";
	if ($_POST['name'] != "") {

		$number = str_replace(',', '.', @$_POST['area']);
		$db->query("INSERT INTO `fields`(`name`, `area`, `farm_id`)  VALUES ('".@$_POST['name']."', '".@$number."', '".$_SESSION["user_farm"]."')");
	}
 ?>