<?php 
	include "../../../dbConfig.php";


	// var_dump($_POST);
	if (@$_POST['quantity'] != "" && @$_POST['chemical_id'] != "" && @$_POST['careset_id'] != "") {
		// echo "Pries vykdant uzklausa\n";
		// var_dump($q);
		$number = str_replace(',', '.', @$_POST['quantity']);
		$q = "INSERT INTO `caresetcontents`(`careset_id`, `chemical_id`, `quantity`, `season_id`, `farm_id`)  VALUES ('".@$_POST['careset_id']."', '".@$_POST['chemical_id']."', '".$number."', '".$_SESSION["user_season"]."', ".$_SESSION["user_farm"].")";
		$db->query($q);
	}
	// echo "Jau po IF'o \n";
 ?>