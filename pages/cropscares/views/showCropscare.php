<!-- @$_GET['id'] -->
<?php

		include_once "../../../dbConfig.php";
		$cropscares = $db->query("SELECT * FROM caresets where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 	

		$caresetcontents = $db->query("SELECT `caresetcontents`.`id` as `id`, `caresetcontents`.`quantity` as `quantity`, `chemicals`.`name` as `name`, `chemicals`.`measure` as measure FROM caresetcontents INNER JOIN chemicals ON `caresetcontents`.chemical_id = `chemicals`.id WHERE `caresetcontents`.farm_id = ".$_SESSION["user_farm"]." AND `caresetcontents`.season_id = '".$_SESSION["user_season"]."' AND `caresetcontents`.careset_id = ".@$_GET['id'].";");
	
			 	
?>  

<div id="cropscares">	
	<h1>Priežiūros darbo informacija</h1>
	<table>
		<tr>
		    <td class="tableLeft">Pavadinimas</td>
			<td class="tableRight"><?php echo @$cropscares[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">L/ha kuro</td>
			<td class="tableRight second"><?php echo @$cropscares[0]['consumption']; ?></td>
		</tr>

		<tr>
		    <td class="tableLeft"><button type="button" class="buttonChange" data-cropscares=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>

	<h2>Priežiūros priemonės</h2>

	<table>
	<?php
		if (@$caresetcontents){			
			$color = 1;
			foreach ($caresetcontents as $key => $chemical) {
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableRight">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					// echo '    <td class="tableLeft">'.@$chemical['name'].'</td>';
					// echo '	  <td class="tableRight">'.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					// echo '    <td class="tableLeft second">'.@$chemical['date'].'</td>';
					// echo '	  <td class="tableRight second">'.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '    <td class="tableRight second">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>

</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/cropscares/views/editCropscare.php?id="
		file += $(this).data('cropscares');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('#cancel').click(function(){
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
		resetMaps();
        var file = "pages/cropscares/index.php";
        $.get(file, function(data){
            $('#content').html(data);
          });
        return false;
    });
</script>