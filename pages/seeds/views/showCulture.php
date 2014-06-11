<?php
	include_once "../../../dbConfig.php";	  	

	$culture = $db->query("SELECT name FROM cultures where id = ".@$_GET['id']);	
	$fields = $db->query("SELECT `fields`.area as area,  `fields`.name as name, `fields`.id as id, `fields`.coordinates as coordinates FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE culture_id = ".@$_GET['id']." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
	
	$seedArea = 0;

	foreach ($fields as $key => $value) {
		$seedArea += $value["area"];
	}
?>  

<div id="culture">	
	<?php 
	echo "<h1>".$culture[0]['name']."</h1>";	
	echo "<table class='fieldsList'>";	
	echo "	<tr>";
	echo "		<td class=\"tableRight\" style=\"text-align: center; padding-top: 5px; padding-bottom: 5px;\"><button id=\"cancel\">Atgal</button></td>";
	echo "		<td class=\"tableSingle\" style=\"text-align: right; width: 20px;\"><a href=\"\"><td>";
	echo "</tr>";
	foreach ($fields as $key => $field) {
		$coord = "";
		if ($field["coordinates"] == ""){
			$coord = "color: red;";
		}
		if ($color == 1) {
			$color = 2;
			echo '<tr>';
			echo '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><td>';
			echo '</tr>';
		} else {
			$color = 1;
			echo '<tr>';
			echo '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><td>';
			echo '</tr>';
		}				
	}

	echo "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>Bendras plotas: ".$seedArea." ha</td><td class='tableSingle second'></td></tr>";
	echo "</table>";

	?>
</div>

<script type="text/javascript">
	$('#cancel').click(function(){
	    var file = "pages/seeds/index.php"
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/fields/views/showField.php?back=showculture&bid="+<?php echo @$_GET['id']; ?>+"&id="
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    paryskinti2($(this).data('field'));
	    return false;
	});
</script>