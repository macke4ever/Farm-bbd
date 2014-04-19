<?php 
	include_once "../../../dbConfig.php";
	if ($_POST['name'] != "") {
		$number1 = str_replace(',', '.', @$_POST['quantity']);
		$number2 = str_replace(',', '.', @$_POST['quantity']);
		$db->query("INSERT INTO `chemicals`(`name`, `measure`, `quantity`, `startQuantity`, `chemtype_id`, `farm_id`)  VALUES ('".@$_POST['name']."', '".@$_POST['measure']."', '".@$number1."', '".@$number2."', '".@$_POST['chemtype_id']."', ".$_SESSION["user_farm"].")");
 	}
 ?>