<?php 
	include_once "../../../dbConfig.php";
	if ($_POST['name'] != "") {
		$number = str_replace(',', '.', @$_POST['quantity']);
		$db->query("INSERT INTO `chemicals`(`name`, `measure`, `quantity`, `chemtype_id`, `farm_id`)  VALUES ('".@$_POST['name']."', '".@$_POST['measure']."', '".@$number."', '".@$_POST['chemtype_id']."', ".$_SESSION["user_farm"].")");
 	}
 ?>