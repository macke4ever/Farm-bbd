<script type="text/javascript">
 <?php 


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
}
 ?>
</script>