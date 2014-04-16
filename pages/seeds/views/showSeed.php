<!-- @$_GET['id'] -->
<?php

	include_once "../../../dbConfig.php";	  
	$seeds = $db->query("SELECT * FROM seeds where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
		 
	if (!empty($seeds)) {
		$cultures = $db->query("SELECT name FROM cultures where id = ".@$seeds[0]['culture_id']);

		if (!empty($cultures)) {
			$seeds[0]["culture"] = $cultures[0]['name'];			 
		} 
	}		


	$fields = $db->query("SELECT `fields`.area as area,  `fields`.name as name, `fields`.id as id, `fields`.coordinates as coordinates FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE seed_id = ".@$_GET['id']." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
	$seedArea = 0;
	foreach ($fields as $key => $value) {
		$seedArea += $value["area"];
	}
?>  

<div id="seeds">	
	<h1>Veislės informacija</h1>
	<table>
		<tr>
		    <td class="tableLeft">Kultūra</td>
			<td class="tableRight"><?php echo @$seeds[0]['culture']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">Pavadinimas</td>
			<td class="tableRight second"><?php echo @$seeds[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft">Kiekis</td>
			<td class="tableRight"><?php echo @$seeds[0]['quantity']; ?>&nbsp;t.</td>
		</tr>
		<tr>
		    <td class="tableLeft second">Plotas</td>
			<td class="tableRight second"><?php echo @$seedArea; ?>&nbsp;t.</td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php if ($_SESSION["user_rights"] >= 16){ ?><button type="button" class="buttonChange" data-seed=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button><?php } ?></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>


	<?php 
	echo "<h2>Laukai kuriuose pasėta ši veislė</h2>";	
	echo "<table class='fieldsList'>";	
	foreach ($fields as $key => $field) {
		$coord = "";
		if ($field["coordinates"] == ""){
			$coord = "color: red;";
		}
		if ($color == 1) {
			$color = 2;
			echo '<tr>';
			echo '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
			echo '<td>';
			echo '</tr>';
		} else {
			$color = 1;
			echo '<tr>';
			echo '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
			echo '<td>';
			echo '</tr>';
		}				
	}

	echo "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>Bendras plotas: ".$seedArea." ha</td><td class='tableSingle second'></td></tr>";
	echo "</table>";

	 ?>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/seeds/views/editSeed.php?id="
		file += $(this).data('seed');
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


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
	    var file = "pages/fields/views/showField.php?back=showseed&bid="+<?php echo @$_GET['id']; ?>+"&id="
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    paryskinti2($(this).data('field'));
	    return false;
	});
</script>