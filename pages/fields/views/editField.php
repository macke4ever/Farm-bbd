<?php

		include "../../../dbConfig.php";
		include "../../../class.text.php";

		$field = $db->query("SELECT
			`fields`.`name` as name,
			`fields`.area as area,
			`laikina`.culture_id,
			cultures.`name` as culture,
			`seeds`.name as seed,
			`tempHarvest`.`date` as harvesting,
			`laikina`.`comment` as season_comment,
			`laikina`.`seed_id` as seed_id,
			`laikina`.`date` as seeddate,
			`laikina`.`quantity` as quantity,
			`fields`.comment as comment
			FROM 
			`fields` 
			LEFT JOIN (SELECT * FROM seedings WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."') as laikina ON `fields`.id = `laikina`.field_id
			LEFT JOIN cultures ON `laikina`.culture_id = `cultures`.id
			LEFT JOIN seeds ON `laikina`.seed_id = `seeds`.id
			LEFT JOIN (SELECT * FROM harvestings where season_id = '".$_SESSION["user_season"]."' and farm_id = '".$_SESSION["user_farm"]."') as tempHarvest ON `fields`.id = `tempHarvest`.field_id
			WHERE
			`fields`.id = '".@$_GET['id']."' AND
			`fields`.farm_id = '".$_SESSION["user_farm"]."'
			LIMIT 1"); 		
	
		$field = $field[0];

	    $cultures = $db->query("SELECT `cultures`.`name` as name, `cultures`.`id` as id FROM seeds INNER JOIN cultures ON `cultures`.`id` = `seeds`.`culture_id` WHERE `seeds`.`farm_id` = ".$_SESSION["user_farm"]." GROUP BY cultures.`name` ORDER BY cultures.`name`");

		$fieldworks = array();	 
		$seedings = $db->query("select id as id, date as date from seedings where farm_id = ".$_SESSION["user_farm"]." and season_id = ".$_SESSION["user_season"]." and field_id = ".@$_GET['id'].""); 		
		if(!empty($seedings)){			
			foreach ($seedings as $key => $seeding) {
				$seeding['name'] = $Text->getText("works_name_seeding");
				$seeding['type'] = "seedings";
				array_push($fieldworks, $seeding);
			}   
		}
		$fieldwork = $db->query("SELECT fieldworks.`name` as `name`, `fieldworks_fields`.`date` as `date`, `fieldworks_fields`.id as id FROM `fieldworks_fields` INNER JOIN fieldworks ON `fieldworks`.id = `fieldworks_fields`.fieldwork_id WHERE `fieldworks_fields`.field_id = '".@$_GET['id']."' AND `fieldworks`.season_id = '".$_SESSION["user_season"]."' AND `fieldworks`.farm_id = '".$_SESSION["user_farm"]."';"); 		 
		if(!empty($fieldwork)){
			foreach ($fieldwork as $key => $fieldwork_one) {
				$fieldwork_one['type'] = "fieldowrks";
				array_push($fieldworks, $fieldwork_one);
			}
		}
		$cropscares = $db->query("SELECT `cropscares`.`id` as `id`, `cropscares`.`date` as `date`, `caresets`.`name` as `name` FROM cropscares INNER JOIN caresets ON `cropscares`.careset_id = `caresets`.id WHERE `caresets`.farm_id = '".$_SESSION["user_farm"]."' AND `caresets`.season_id = '".$_SESSION["user_season"]."' AND `cropscares`.field_id = ".@$_GET['id'].";"); 		 
		if(!empty($cropscares)){
			foreach ($cropscares as $key => $cropscare) {
				$cropscare['type'] = "cropscares";
				array_push($fieldworks, $cropscare);
			}
		}

		//Masyvo rusiavimas, cia nusirodo kaip ji rusiuoti pagal data, kadangi tai yra masyvas is masyvu
		function invenDescSort($item1,$item2)
		{
		    if ($item1['date'] == $item2['date']) return 0;
		    return ($item1['date'] > $item2['date']) ? 1 : -1;
		}
		if (!empty($fieldworks)){
			usort($fieldworks,'invenDescSort');
		}

?>  

<div id="fields">	
	<h1><?php echo $Text->getText("fields_edit"); ?></h1>
	<form id="changeField" action="pages/fields/actions/changeField.php" method="post">
		<table>
			<tr>
			    <td class="tableLeft"><?php echo $Text->getText("form_name"); ?></td>
				<td class="tableRight"><input id="name" name="name" type="text" value=<?php echo '"'.@$field['name'].'"'; ?> /></td>
			</tr>
			<tr>
			    <td class="tableLeft second"><?php echo $Text->getText("form_area"); ?></td>
				<td class="tableRight second"><input id="area" name="area" type="text" value=<?php echo '"'.@$field['area'].'"'; ?> /></td>
			</tr>
			<tr>
			    <td class="tableLeft"><?php echo $Text->getText("seeds_culture"); ?></td>
				<td class="tableRight">
					
					<select data-placeholder="Pasirinkite kultūrą" name="selectedSeed" id="seedSelect" style="width: 261px;" >
					<option value=""></option>
					<?php
						foreach($cultures as $key => $culture){
				            echo '<optgroup label="'.$culture["name"].'">';
				            $q = "SELECT id, name FROM seeds WHERE `farm_id`=".$_SESSION["user_farm"]." and `culture_id`='".@$culture["id"]."' ORDER BY seeds.name";
				            $rc = mysql_query($q);			    
				            $seeds = array();
				            while(@$seed = mysql_fetch_assoc($rc)){
				                @$seeds[@$seed['id']] = @$seed;
				                if (@$seed['id'] == @$field['seed_id']) {
				                	echo '<option value="'.@$seed['id'].'" selected="selected">'.@$seed["name"].'</option>';
				                } else {
				                	echo '<option value="'.@$seed['id'].'">'.@$seed["name"].'</option>';
				                }
				            }
				            echo "</optgroup>";
	        			}
					?>
				</td>
			</tr>
			<tr>
			    <td class="tableLeft second"><?php echo $Text->getText("fields_seeding_date"); ?></td>
				<td class="tableRight second"><input id="seeddate" name="seeddate" type="date" value=<?php echo '"'.@$field['seeddate'].'"'; ?> /></td>
			</tr>
			<tr>
			    <td class="tableLeft"><?php echo $Text->getText("fields_seed_quantity"); ?></td>
				<td class="tableRight"><input id="quantity" name="quantity" type="text" value=<?php echo '"'.@$field['quantity'].'"'; ?> style="width:50px; text-align: right;"> kg</td>
			</tr>
			<tr>
			    <td class="tableLeft second"><?php echo $Text->getText("form_harvest_date"); ?></td>
				<td class="tableRight second"><input id="date" name="date" type="date" value=<?php echo '"'.@$field['harvesting'].'"'; ?> /></td>
			</tr>
			<tr>
			    <td class="tableLeft"><?php echo $Text->getText("form_comment"); ?></td>
				<td class="tableRight"><textarea id="comment" name="comment" cols="30"><?php echo @$field['comment']; ?></textarea></td>
			</tr>
			<?php 
				if ($field['culture']) {
			?>
					<tr>
					    <td class="tableLeft second"><?php echo $Text->getText("form_season_comment"); ?></td>
						<td class="tableRight second"><textarea id="season_comment" name="season_comment" cols="30"><?php echo @$field['season_comment']; ?></textarea></td>
					</tr>
			<?php } ?>
			<tr>
				<input type="hidden" id="field_id" name="field_id" value=<?php echo '"'.@$_GET['id'].'"'; ?> />
			    <td class="tableLeft"><input type="submit" id="submit" value="<?php echo $Text->getText("form_save"); ?>" data-field=<?php echo '"'. @$_GET['id']. '"'; ?>/></td>
				<td class="tableRight"><button id="cancel" data-field=<?php echo '"'. @$_GET['id']. '"'; ?>><?php echo $Text->getText("form_back"); ?></button></td>
			</tr>
		</table>
	</form>

	<div id="coordContent"><?php include "coordinates.php"; ?></div>
	<button id="deleteCoord" style="margin-left: 15px;" data-field=<?php echo '"'. @$_GET['id']. '"'; ?>><?php echo $Text->getText("fields_delete_coord"); ?></button><br>


	<h2><?php echo $Text->getText("fields_works_in_field"); ?></h2>

	<table>
	<?php
		if (@$fieldworks){			
			$color = 1;
			foreach ($fieldworks as $key => $work) {
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableLeft">'.$work['date'].'</td>';
					echo '	  <td class="tableRight">'.$work['name'].'</td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" data-type="'.@$work['type'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableLeft second">'.$work['date'].'</td>';
					echo '	  <td class="tableRight second">'.$work['name'].'</td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" data-type="'.@$work['type'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>

</div>

<script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#changeField").submit(function(event) {
      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, { date: $('#date').val(), comment: $('#comment').val(), name: $('#name').val(), area: $('#area').val(), season_comment: $('#season_comment').val(), field_id: $('#field_id').val(), seedSelect: $('#seedSelect').val(), seeddate: $('#seeddate').val(), quantity: $('#quantity').val() } );
      
      $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/fields/views/showField.php?id='.@$_GET["id"].'";' ?>
        $.get(file, function(data){$('#content').html(data);});
        reloadMaps();
        paryskinti2(<?php echo @$_GET["id"]; ?>);
      });
    });


$('.delete').click(function(){
    if (confirm(<?php echo "\"".$Text->getText("fields_message_delete_work")."\""; ?>)) {    	
	    var url = "pages/deleteWorkFromField.php";	    
	    var posting = $.post( url, { id: $(this).data('id'),  type: $(this).data('type') } );

	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	      
	      /* Put the results in a div */
	      posting.done(function( data ) {
	        <?php echo "var file = \"pages/fields/views/showField.php?id=".@$_GET['id']."\";"; ?>
	        $.get(file, function(data){
	        	$('#content').html(data);
	        });
	      });
    }
    return false;
});

$('#deleteCoord').click(function(){
	if (confirm(<?php echo "\"".$Text->getText("fields_message_delete_coord")."\""; ?>)) { 
	    var url = "upload/deleteCoord.php";	   
	    var posting = $.post( url, { id: $(this).data('field') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        	reloadMaps();
	      });
	}
    return false;
});

	$('#cancel').click(function(){
	    var file = "pages/fields/views/showField.php?id="
		file += $(this).data('field');

	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});
</script>

<script type="text/javascript">
 	 -->$("#seedSelect").chosen();
 	$("#seedSelect").chosen({allow_single_deselect:true});
</script>

<!-- , function(responseText, responseState){ alert(responseText);} reikalingas kai nori pasidebuginti teksta -->