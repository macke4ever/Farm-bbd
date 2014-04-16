<?php 
	session_start();
 ?>
<div id="chemical">	
	
	<h1>Pasėlių priežiūros priemonės</h1><?php if ($_SESSION["user_rights"] >= 16){ ?><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a><?php } ?>


<?php

	include "../../dbConfig.php";	   
	$chemtypes = $db->query("SELECT `chemtypes`.`id` as id, `chemtypes`.`tableName` as tableName FROM chemicals INNER JOIN chemtypes ON `chemicals`.chemtype_id = `chemtypes`.id WHERE `chemicals`.farm_id = ".$_SESSION["user_farm"]." GROUP BY `chemtypes`.`tableName` ORDER BY tableName ASC"); 			
	foreach ($chemtypes as $key => $chemtype) {
		echo "<h2>".$chemtype['tableName']."</h2>";
		echo "<table>";
			$color = 1;
			$chemicals = $db->query("SELECT id, `name` FROM chemicals WHERE farm_id = ".$_SESSION["user_farm"]." and chemtype_id = ".$chemtype['id']." ORDER BY `name` ASC"); 		
			foreach ($chemicals as $key => $chemical) {		
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableSingle show" data-id="'.@$chemical['id'].'"><a href="" class="aStyle">'.@$chemical['name'].'</a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$chemical['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
					}
					echo '<td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableSingle second show" data-id="'.@$chemical['id'].'"><a href="" class="aStyle">'.@$chemical['name'].'</a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$chemical['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
					}
					echo '<td>';
					echo '</tr>';
				}
			}

		echo "</table>";
  }?> 
</div>

<script type="text/javascript">
	$('.addButton').click(function(){
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/chemicals/views/addChemical.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


  $('.show').click(function(){
	$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	var file = "pages/chemicals/views/showChemical.php?id="
	file += $(this).data('id');
    $.get(file, function(data){
        $('#content').html(data);
      });
    return false;
  });

    $('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą chemikalą?")) {    	
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var url = "pages/chemicals/actions/deleteChemical.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/chemicals/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>