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


	$seedAreas = $db->query("SELECT `fields`.area as area FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE seed_id = ".@$_GET['id']." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
	$seedArea = 0;
	foreach ($seedAreas as $key => $value) {
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
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/seeds/views/editSeed.php?id="
		file += $(this).data('seed');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


	$('#cancel').click(function(){
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/seeds/index.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    return false;
	});
</script>