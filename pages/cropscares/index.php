<?php

	include "../../dbConfig.php";	   
	include "../../class.text.php";	

	$cropscares = $db->query("SELECT name, id FROM caresets where farm_id = ".$_SESSION["user_farm"]." and season_id = ".$_SESSION["user_season"]." ORDER BY name ASC "); 

?>  

<div id="cropscare">	
	<h1><?php echo $Text->getText("cropscares"); ?></h1><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>

	<table>
	<?php
		if (@$cropscares){			
			$color = 1;
			foreach ($cropscares as $key => $work) {
				// echo "SELECT sum(`fields`.area) as area FROM cropscares LEFT OUTER JOIN `fields` ON `cropscares`.`field_id` = `fields`.id  WHERE cropscare_id = ".$work["id"].";";
				$cropscareArea = $db->query("SELECT sum(`fields`.area) as area FROM cropscares LEFT OUTER JOIN `fields` ON `cropscares`.`field_id` = `fields`.id  WHERE careset_id = ".$work["id"].";"); 
				$cropscareArea = round($cropscareArea[0]["area"], 2);
				$totalArea += $cropscareArea;
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableSingle show" data-work="'.$work["id"].'"><a href="" class="aStyle">'.$work['name'].' <strong>'.$cropscareArea.' ha</strong></a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableSingle second show" data-work="'.$work["id"].'"><a href="" class="aStyle">'.$work['name'].' <strong>'.$cropscareArea.' ha</strong></a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>

	<?php 

		echo "<h2>".$Text->getText("cropscares_area").": ".$totalArea." ha</h2>";

	 ?>
</div>


<script type="text/javascript">
	$('.addButton').click(function(){
	    var file = "pages/cropscares/views/addCropscare.php"
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/cropscares/views/showCropscare.php?id="
		file += $(this).data('work');

	    var file2 = "markWorkFields.php?workType=cropscare&workID="
		file2 += $(this).data('work');
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

	    $.get(file, function(data){
	        $('#content').html(data);
	      });

	    $.get(file2, function(data){
	        $('#content2').html(data);
	      });
	    return false;
	});


    $('.delete').click(function(){
    if (confirm(<?php echo "\"".$Text->getText("cropscares_message_delete")."\""; ?>)) {    	
	    var url = "pages/cropscares/actions/deleteCropscare.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/cropscares/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>