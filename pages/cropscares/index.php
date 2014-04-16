<?php

	include "../../dbConfig.php";	   
	$cropscares = $db->query("SELECT name, id FROM caresets where farm_id = ".$_SESSION["user_farm"]." and season_id = ".$_SESSION["user_season"]." ORDER BY name ASC "); 

?>  

<div id="cropscare">	
	<h1>Pasėlių priežiūros darbai</h1><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>

	<table>
	<?php
		if (@$cropscares){			
			$color = 1;
			foreach ($cropscares as $key => $work) {
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableSingle show" data-work="'.$work["id"].'"><a href="" class="aStyle">'.$work['name'].'</a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableSingle second show" data-work="'.$work["id"].'"><a href="" class="aStyle">'.$work['name'].'</a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>
</div>


<script type="text/javascript">
	$('.addButton').click(function(){
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/cropscares/views/addCropscare.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/cropscares/views/showCropscare.php?id="
		file += $(this).data('work');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });

	    var file2 = "markWorkFields.php?workType=cropscare&workID="
		file2 += $(this).data('work');
	    $.get(file2, function(data){
	        $('#content2').html(data);
	      });
	    return false;
	});


    $('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą darbą?\n\nKartu bus pašalinti šio tipo darbai iš kitų laukų .")) {    	
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var url = "pages/cropscares/actions/deleteCropscare.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/cropscares/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>