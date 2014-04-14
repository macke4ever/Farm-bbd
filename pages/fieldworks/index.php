<?php

	include_once "../../dbConfig.php";

	$fieldworks = $db->query("SELECT name, id FROM fieldworks where farm_id = ".$_SESSION["user_farm"]." and season_id = ".$_SESSION["user_season"]." ORDER BY name ASC ");	
	
?>  

<div id="fieldwork">	
	<h1>Žemės dirbimai laukuose</h1><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>

	<table>
	<?php
		if (@$fieldworks){			
			$color = 1;
			foreach ($fieldworks as $key => $work) {
				if ($color == 1) {
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
	    var file = "pages/fieldworks/views/addFieldwork.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/fieldworks/views/showFieldwork.php?id="
		file += $(this).data('work');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });

	    var file2 = "markWorkFields.php?workType=fieldwork&workID="
		file2 += $(this).data('work');
	    $.get(file2, function(data){
	        $('#content2').html(data);
	      });
	    return false;
	});


    $('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą darbą?\n\nKartu bus pašalinti šio tipo darbai iš kitų laukų .")) {    	
	    var url = "pages/fieldworks/actions/deleteFieldwork.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/fieldworks/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>