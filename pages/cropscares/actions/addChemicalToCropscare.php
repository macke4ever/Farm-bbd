<?php 
	include "../../../dbConfig.php";


	// var_dump($_POST);
	if (@$_POST['quantity'] != "" && @$_POST['chemical_id'] != "" && @$_POST['careset_id'] != "") {

		$number = str_replace(',', '.', @$_POST['quantity']);
		$q = "INSERT INTO `caresetcontents`(`careset_id`, `chemical_id`, `quantity`, `season_id`, `farm_id`)  VALUES ('".@$_POST['careset_id']."', '".@$_POST['chemical_id']."', '".$number."', '".$_SESSION["user_season"]."', ".$_SESSION["user_farm"].")";
		$db->query($q);
	

		$chemicals = $db->query("SELECT `caresetcontents`.quantity as quantity, `chemicals`.price as price FROM caresetcontents LEFT OUTER JOIN chemicals ON `caresetcontents`.chemical_id = `chemicals`.id WHERE `caresetcontents`.careset_id = '".@$_POST['careset_id']."'");
		$price = 0;	
		foreach ($chemicals as $key => $chemical) {
			$price += $chemical["quantity"]*$chemical["price"];
		}
		$price = round($price, 2);
	}
	// echo "Jau po IF'o \n";
 ?>