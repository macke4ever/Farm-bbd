<?php 
		include_once "../../../dbConfig.php";
		session_start();
		$caresetcontents = $db->query("SELECT `caresetcontents`.`id` as `id`, `caresetcontents`.`quantity` as `quantity`, `chemicals`.`name` as `name`, `chemicals`.`measure` as measure FROM caresetcontents INNER JOIN chemicals ON `caresetcontents`.chemical_id = `chemicals`.id WHERE `caresetcontents`.farm_id = ".$_SESSION["user_farm"]." AND `caresetcontents`.season_id = '".$_SESSION["user_season"]."' AND `caresetcontents`.careset_id = ".@$_GET['id'].";");
		$caresetAreas = $db->query("SELECT `fields`.area as area, `fields`.name as name, `fields`.coordinates as coordinates, `fields`.id as id FROM cropscares LEFT OUTER JOIN `fields` ON `cropscares`.`field_id` = `fields`.id  WHERE careset_id = ".$_GET["id"]." ORDER BY `fields`.name ASC;"); 
		
		$area = 0;
		foreach ($caresetAreas as $key => $value) {
			$area += $value["area"];
		}	

	//generating fields list
	$fieldsReturn = "";

	$fieldsReturn .= "<h2>Išdirbti laukai</h2>";	
	$fieldsReturn .=  "<table class='fieldsList'>";	
	foreach ($caresetAreas as $key => $field) {
		$coord = "";
		if ($field["coordinates"] == ""){
			$coord = "color: red;";
		}
		if ($color == 1) {
			$color = 2;
			$fieldsReturn .=  '<tr>';
			$fieldsReturn .=  '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			$fieldsReturn .=  '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
			$fieldsReturn .=  '<td>';
			$fieldsReturn .=  '</tr>';
		} else {
			$color = 1;
			$fieldsReturn .=  '<tr>';
			$fieldsReturn .=  '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			$fieldsReturn .=  '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
			$fieldsReturn .=  '<td>';
			$fieldsReturn .=  '</tr>';
		}				
	}

	$fieldsReturn .=  "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>Bendras priežiūros darbų plotas: ".$area." ha</td><td class='tableSingle second'></td></tr>";
	$fieldsReturn .=  "<tr><td class='tableSingle second' style='padding-top: 5px; font-weight: bold;'>Sunaudota kuro: ".$area*@$_GET['consumption']." l</td><td class='tableSingle second'></td></tr>";
	$fieldsReturn .=  "</table>";


	//generating chemicals and quantity of them use list.
	$chemicalsReturn = "";
	$chemicalsReturn .= "<h2>Priežiūros priemonės</h2>";
	$chemicalsReturn .= "<table>";
		if (@$caresetcontents){			
			$color = 1;
			foreach ($caresetcontents as $key => $chemical) {
				$totalQ = '(<strong>'.round($area*@$chemical['quantity'], 2).' '.@$chemical['measure'].'</strong>)';
				if ($color == 1)
				{
					$color = 2;
					$chemicalsReturn .= '<tr>';
					$chemicalsReturn .= '    <td class="tableRight">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].' '.$totalQ.'</td>';
					$chemicalsReturn .= '</tr>';
				} else {
					$color = 1;
					$chemicalsReturn .= '<tr>';
					$chemicalsReturn .= '    <td class="tableRight second">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].' '.$totalQ.'</td>';
					$chemicalsReturn .= '</tr>';
				}
			}
		} 
	$chemicalsReturn .= "</table>";

	$array = array('fieldsReturn' => $fieldsReturn, 'chemicalsReturn' => $chemicalsReturn, 'area' => $area);

	echo json_encode($array);
 
 ?>