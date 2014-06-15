<!-- @$_GET['id'] -->
<?php

	include_once "../../../dbConfig.php";
	include_once "../../../class.text.php";

	$cropscare = $db->query("SELECT * FROM caresets where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 	
	$caresetcontents = $db->query("SELECT `caresetcontents`.`id` as `id`, `caresetcontents`.`quantity` as `quantity`, `chemicals`.`name` as `name`, `chemicals`.`measure` as measure FROM caresetcontents INNER JOIN chemicals ON `caresetcontents`.chemical_id = `chemicals`.id WHERE `caresetcontents`.farm_id = ".$_SESSION["user_farm"]." AND `caresetcontents`.season_id = '".$_SESSION["user_season"]."' AND `caresetcontents`.careset_id = ".@$_GET['id'].";");	

?>  

<h1><?php echo $Text->getText("cropscare_edit"); ?></h1>
<form id="changeCropscare" action="pages/cropscares/actions/changeCropscare.php" method="post">
	<table>
		<tr>
			<td class="tableLeft "><?php echo $Text->getText("form_name"); ?></td>
			<td class="tableRight "><input type="text" name="name" id="name" value=<?php echo '"'.$cropscare[0]["name"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft second"><?php echo $Text->getText("form_fuel"); ?></td>
			<td class="tableRight second"><input type="text" name="consumption" id="consumption" value=<?php echo '"'.$cropscare[0]["consumption"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="<?php echo $Text->getText("form_save"); ?>"/></td>
			<td class="tableRight"><input type="hidden" id="id" name="id" value=<?php echo '"'.$cropscare[0]["id"].'"'; ?>/><button type="cancel" id="cancel" data-cropscare=<?php echo '"'. @$_GET['id']. '"'; ?>><?php echo $Text->getText("form_back"); ?></button></td>
		</tr>
	</table>
</form>

	<?php include "addChemicalForm.php" ?>

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
					echo '    <td class="tableRight" style="width: 100%">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$chemical['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					// echo '    <td class="tableLeft">'.@$chemical['name'].'</td>';
					// echo '	  <td class="tableRight">'.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					// echo '    <td class="tableLeft second">'.@$chemical['date'].'</td>';
					// echo '	  <td class="tableRight second">'.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '    <td class="tableRight second" style="width: 100%">'.@$chemical['name'].' '.@$chemical['quantity'].' '.@$chemical['measure'].'</td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$chemical['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>
<div id="garbage">&nbsp;</div>

<script type='text/javascript'>

    /* attach a submit handler to the form */
    $("#changeCropscare").submit(function(event) {
      event.preventDefault();
      var $form = $( this ),
          url = $form.attr( 'action' );
      var posting = $.post( url, { name: $('#name').val(), consumption: $('#consumption').val(), id: $('#id').val() } );
      
      $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
      
      posting.done(function( data ) {
        <?php echo 'var file = "pages/cropscares/views/showCropscare.php?id='.@$_GET["id"].'";' ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });

    $('#cancel').click(function(){
	    var file = "pages/cropscares/views/showCropscare.php?id="
		file += $(this).data('cropscare');
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.delete').click(function(){
	    if (confirm(<?php echo "\"".$Text->getText("cropscares_message_delete_tool")."\""; ?>)) {    	
		    var url = "pages/cropscares/actions/deleteChemicalFromCropscare.php";	
		    var posting = $.post( url, { id: $(this).data('id') }, function(result){
		    	//response text spausdinimas is to failo i kuri kreipiamasi su post
		    	// var response = result;
		    	// $('#garbage').html('response');
		    	// console.log(response);
		    });
		    
		    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
		      /* Put the results in a div */
		      posting.done(function( data ) {
		      	console.log("veiksmas atliktas");
		        <?php echo "var file = \"pages/cropscares/views/editCropscare.php?id=".@$_GET['id']."\";"; ?>
		        $.get(file, function(data){
		        	$('#content').html(data);
		        });
		      });
	    }
	    return false;
	});
</script>
