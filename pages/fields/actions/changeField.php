<?php 
	include "../../../dbConfig.php";

	
	//updating season seeding information
	//updating comment
	$result = $db->query("SELECT * FROM `seedings` WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."' AND field_id='".@$_POST['field_id']."'");
	if ($result) {
		$db->query("UPDATE `seedings` SET `comment`='".@$_POST['season_comment']."' WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."' AND field_id='".@$_POST['field_id']."'");
	}


	//echo @$_POST["seedSelect"];
	if (@$_POST["seedSelect"] != "") {		
		//getting seed's culture ID
		$culture_id = $db->query("SELECT * FROM seeds INNER JOIN cultures ON `cultures`.id = `seeds`.`culture_id` WHERE `seeds`.`id`='".@$_POST["seedSelect"]."' and `seeds`.`farm_id`='".$_SESSION["user_farm"]."' LIMIT 1");		
		
		if (empty($_POST['seeddate'])){
			$date = date("Y-m-d");
		} else {
			$date = @$_POST['seeddate'];
		}

		$quantity = str_replace(',', '.', @$_POST['quantity']);
		if ($result) {
			//modify resources when adding a seeding to the field
			//add to resources when seeding is modified
			$seed_id = $db->query("SELECT seed_id from seedings WHERE farm_id='".$_SESSION["user_farm"]."' and field_id='".@$_POST['field_id']."' and season_id='".$_SESSION["user_season"]."'"); 
			if (!empty($seed_id)){			
				$fields = $db->query("SELECT area from fields where id = '".@$_POST['field_id']."'"); 		
				if(!empty($fields)){	
					$numbVal = $fields[0]["area"] * @$_POST["quantity"];		 		
					$db->query("UPDATE seeds SET quantity = (quantity + ".$numbVal."/1000) WHERE id = '".$seed_id[0]["seed_id"]."'");   
				}
			}

			$db->query("UPDATE seedings SET `seed_id`='".$_POST['seedSelect']."', `culture_id`='".$culture_id[0]['id']."', `date`='".$date."', `quantity`='".$quantity."' WHERE farm_id='".$_SESSION["user_farm"]."' and field_id='".@$_POST['field_id']."' and season_id='".$_SESSION["user_season"]."'");	
		} else {
			$db->query("INSERT INTO seedings (seed_id, season_id, farm_id, field_id, done, culture_id, `date`, quantity) VALUES ('".$_POST["seedSelect"]."', '".$_SESSION["user_season"]."', '".$_SESSION["user_farm"]."', '".@$_POST['field_id']."', '0', '".$culture_id[0]['id']."', '".$date."', '".$quantity."')");
			
		}
		//modify resources when adding a seeding to the field
		//removes from resources when seeding is added to the field
		$fields = $db->query("SELECT area from fields where id = '".@$_POST['field_id']."'"); 		
		if(!empty($fields)){			 		
			$numbVal = $fields[0]["area"] * @$_POST["quantity"];
			$db->query("UPDATE seeds SET quantity = (quantity - ".$numbVal."/1000) WHERE id = '".$_POST["seedSelect"]."'");   
		}

	} else {
		
		//modify resources when adding a seeding to the field
		//add to resources when seeding is deleted
		$seed_id = $db->query("SELECT seed_id, quantity from seedings WHERE farm_id='".$_SESSION["user_farm"]."' and field_id='".@$_POST['field_id']."' and season_id='".$_SESSION["user_season"]."'"); 
		if (!empty($seed_id)){			
			$fields = $db->query("SELECT area from fields where id = '".@$_POST['field_id']."'"); 		
			if(!empty($fields)){
				$numbVal = $fields[0]["area"] * $seed_id[0]["quantity"];
				$db->query("UPDATE seeds SET quantity = (quantity + ".$numbVal."/1000) WHERE id = '".$seed_id[0]["seed_id"]."'");   
			}
		}
	
		$db->query("DELETE from seedings WHERE farm_id='".$_SESSION["user_farm"]."' and field_id='".@$_POST['field_id']."' and season_id='".$_SESSION["user_season"]."'");	
	

	}


		//var_dump($_POST);	
		$result = $db->query("SELECT * FROM `harvestings` WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."' AND field_id='".@$_POST['field_id']."'");

		if ($result) {
			$db->query("UPDATE `harvestings` SET `date`='".@$_POST['date']."' WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."' AND field_id='".@$_POST['field_id']."'");
		} else {
			$db->query("INSERT INTO `harvestings`(`field_id`, `season_id`, `farm_id`, `date`)  VALUES ('".@$_POST['field_id']."', '".$_SESSION["user_season"]."', '".$_SESSION["user_farm"]."', '".@$_POST['date']."')");
		}



	//updating field info
	$area = str_replace(',', '.', @$_POST['area']);
	$db->query("UPDATE `fields` SET `comment`='".@$_POST['comment']."', `name`='".@$_POST['name']."', `area`='".$area."' WHERE id='".@$_POST['field_id']."'");


 ?>