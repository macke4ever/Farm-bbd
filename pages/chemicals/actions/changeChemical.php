<?php 
	include_once "../../../dbConfig.php";

	if (($_POST['name'] != "") && ($_POST['measure'] != "")) {
		$number1 = str_replace(',', '.', @$_POST['quantity']);
		$number2 = str_replace(',', '.', @$_POST['startQuantity']);
		$db->query("UPDATE `chemicals` SET `name`='".@$_POST['name']."', `chemtype_id`='".@$_POST['chemtype_id']."', `measure`='".@$_POST['measure']."', `quantity`='".@$number1."', `startQuantity`='".@$number2."' WHERE farm_id = ".$_SESSION["user_farm"]." AND id='".@$_POST['id']."'");
	}

 ?>