<?php 
	//this needs to be edited. When deleting an element not only this record shoulkd be removed but all other tables records that are connected to this one.
	session_start();
	include "../../../dbConfig.php";
	if (@$_POST["type"] == "fieldowrks") {		
		$db->query("DELETE FROM fieldworks_fields WHERE id='".@$_POST['id']."'");
	}


	if (@$_POST["type"] == "cropscares") {

		//modify resources when adding a work to the field
		$fields = $db->query("SELECT area from fields where id = '".@$_POST['field_id']."'"); 	
		$careset_id = $db->query("SELECT careset_id from cropscares where id = '".@$_POST['id']."'");	
		if(!empty($fields)){			
			$chemicals = $db->query("SELECT quantity, chemical_id from caresetcontents where farm_id = '".$_SESSION["user_farm"]."' and season_id = '".$_SESSION["user_season"]."' and careset_id = '".$careset_id[0]["careset_id"]."'"); 		
			if(!empty($chemicals)){			
				foreach ($chemicals as $key => $chemical) {
					$numbVal = $fields[0]["area"]."*".$chemical["quantity"];
					$db->query("UPDATE chemicals SET quantity = (quantity + ".$numbVal.") WHERE id = '".$chemical["chemical_id"]."'");
				}   
			}  
		}

		$db->query("DELETE FROM cropscares WHERE id='".@$_POST['id']."'");
	}

	if (@$_POST["type"] == "seedings") {
		$db->query("DELETE FROM seedings WHERE id='".@$_POST['id']."'");
	}
 ?>