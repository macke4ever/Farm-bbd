<?php 
	include "../../../dbConfig.php";


	if (@$_POST['workType'] != "" && @$_POST['id'] != 0) {
		if (empty($_POST['date'])){
			$date = date("Y-m-d");
		} else {
			$date = @$_POST['date'];
		}
		if  (@$_POST['workType'] == "fieldWork")
		{			
			$db->query("INSERT INTO `fieldworks_fields`(`fieldwork_id`, `field_id`, `done`, `date`)  VALUES ('".@$_POST['id']."', '".@$_POST['field_id']."', '1', '".$date."')");
		}
		if  (@$_POST['workType'] == "cropscare")
		{			
			$db->query("INSERT INTO `cropscares`(`careset_id`, `field_id`, `done`, `date`)  VALUES ('".@$_POST['id']."', '".@$_POST['field_id']."', '1', '".$date."')");
			

			//rmodify resources when adding a work to the field
			$fields = $db->query("SELECT area from fields where id = '".@$_POST['field_id']."'"); 		
			if(!empty($fields)){			
				$chemicals = $db->query("SELECT quantity, chemical_id from caresetcontents where farm_id = '".$_SESSION["user_farm"]."' and season_id = '".$_SESSION["user_season"]."' and careset_id = '".@$_POST['id']."'"); 		
				if(!empty($chemicals)){			
					foreach ($chemicals as $key => $chemical) {
						$numbVal = $fields[0]["area"] * $chemical["quantity"];
						$db->query("UPDATE chemicals SET quantity = (quantity - ".$numbVal.") WHERE id = '".$chemical["chemical_id"]."'");
					}   
				}   
			}


		}
	}
 ?>