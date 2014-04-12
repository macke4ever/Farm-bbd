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
		    <td class="tableLeft"><button type="button" class="buttonChange" data-seed=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/seeds/views/editSeed.php?id="
		file += $(this).data('seed');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


	$('#cancel').click(function(){
	    var file = "pages/seeds/index.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});
</script>