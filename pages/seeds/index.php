<?php 
	session_start();
 ?>
<div id="seeds">	
	
	<h1>Pasėlių veislės</h1><?php if ($_SESSION["user_rights"] >= 16){ ?><a href=""><img src="img/add.png" class="addButton" tabindex="1" data-id="'.@$seed['id'].'" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a><?php } ?>


<?php

	include_once "../../dbConfig.php";
	$cultures = $db->query("SELECT cultures.`name` as tableName, `cultures`.id as id FROM seeds INNER JOIN cultures ON `seeds`.culture_id = `cultures`.id WHERE `seeds`.farm_id = ".$_SESSION["user_farm"]." GROUP BY cultures.`name` ORDER BY cultures.`name` ASC"); 			
	
	foreach ($cultures as $key => $culture) {
		echo "<h2>".$culture['tableName']."</h2>";
		echo "<table>";
			$color = 1;
			$seeds = $db->query("SELECT id, `name` FROM seeds WHERE farm_id = ".$_SESSION["user_farm"]." and culture_id = ".$culture['id']." ORDER BY `name` ASC"); 		
			foreach ($seeds as $key => $seed) {
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableSingle show" data-id="'.@$seed['id'].'"><a href="" class="aStyle">'.@$seed['name'].'</a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
					}
					echo '<td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableSingle second show" data-id="'.@$seed['id'].'"><a href="" class="aStyle">'.@$seed['name'].'</a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
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
	    var file = "pages/seeds/views/addSeed.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


  $('.show').click(function(){
	var file = "pages/seeds/views/showSeed.php?id="
	file += $(this).data('id');
    $.get(file, function(data){
        $('#content').html(data);
      });
    return false;
  });

    $('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą veislę?")) {    	
	    var url = "pages/seeds/actions/deleteSeed.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/seeds/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>