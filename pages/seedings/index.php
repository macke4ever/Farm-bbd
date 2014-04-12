<?php

	// include_once "../../db.class.php";
	include_once "../../dbConfig.php";

    $q = "SELECT * FROM seedings inner join cultures on `seedings`.culture_id = `cultures`.id where `seedings`.farm_id = 4 and `seedings`.season_id = 5 group by `seedings`.culture_id";
    $cultures = $db->query($q);
	// $fieldworks = $db->query("SELECT name, id FROM fieldworks where farm_id = 4 and season_id = 5 ORDER BY name ASC ");	
		
	
?>  

<div id="seedings">	
	<h1>Sėjos darbai</h1><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>

	<table>
	<?php
		// var_dump($q);	
		if (@$cultures){
			foreach ($cultures as $key => $culture) {
				# code...
				$seeds = $db->query("SELECT * FROM seedings inner join seeds on `seedings`.seed_id = `seeds`.id where `seedings`.farm_id = 4 and `seedings`.season_id = 5 and `seedings`.culture_id = ".$culture['id']);
				// var_dump($seeds);
				echo '<h2>'.$culture['name'].'</h2>';
				$color = 1;
				foreach ($seeds as $key => $seed) {
					if ($color == 1) {
						$color = 2;
						echo '<tr>';
						echo '    <td class="tableSingle show" data-seed="'.$seed["id"].'"><a href="" class="aStyle">'.$seed['name'].'</a></td>';
						echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
						echo '</tr>';
					} else {
						$color = 1;
						echo '<tr>';
						echo '    <td class="tableSingle second show" data-seed="'.$seed["id"].'"><a href="" class="aStyle">'.$seed['name'].'</a></td>';
						echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
						echo '</tr>';
					}	
				}
			}
		} 
	 ?>
	</table>
</div>


<script type="text/javascript">
	$('.addButton').click(function(){
	    var file = "pages/seedings/views/addSeeding.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/seedings/views/showSeeding.php?id="
		file += $(this).data('seed');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


    $('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą darbą?\n\nKartu bus pašalinti šio tipo darbai iš kitų laukų .")) {    	
	    var url = "pages/seedings/actions/deleteFieldwork.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/seedings/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>