<script type="text/javascript">
 <?php 

session_start();

 include "dbConfig.php";
 $workType = "";
 $workID = "";

 	if (!empty($_GET["workType"])){
 		$workType = $_GET["workType"];
 	}

 	if (!empty($_GET["workID"])){
 		$workID = $_GET["workID"];
 	}

if ($workType != "" && $workID != ""){
	if ($workType == "cropscare"){
		$cropscares = $db->query("SELECT  field_id FROM cropscares WHERE careset_id = '".$workID."'"); 
		foreach ($cropscares as $key => $cropscare) {
			echo "paryskinti2(".$cropscare["field_id"].");";
		}
	}

	if ($workType == "fieldwork"){
		$fieldworks = $db->query("SELECT field_id FROM fieldworks_fields WHERE fieldwork_id = '".$workID."'"); 
		foreach ($fieldworks as $key => $fieldwork) {
			echo "paryskinti2(".$fieldwork["field_id"].");";
		}
	}

	if ($workType == "seed"){
		$fields = $db->query("SELECT `fields`.id as id FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE seed_id = ".$workID." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
		foreach ($fields as $key => $field) {
			echo "paryskinti2(".$field["id"].");";
		}
	}

	if ($workType == "culture"){
		$fields = $db->query("SELECT `fields`.id as id FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE culture_id = ".$workID." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
		foreach ($fields as $key => $field) {
			echo "paryskinti2(".$field["id"].");";
		}
	}
}
 ?>
</script>