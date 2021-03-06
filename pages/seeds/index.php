<?php 
	session_start();

	include_once "../../dbConfig.php";
	include_once "../../class.text.php";
 ?>
<div id="seeds">	
<?php 	
	echo "<h1>".$Text->getText("seeds")."</h1>";

	if ($_SESSION["user_rights"] >= 16){ ?>
		<a href=""><img src="img/add.png" class="addButton" tabindex="1" data-id="'.@$seed['id'].'" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>
<?php } 



	$cultures = $db->query("SELECT cultures.`name` as tableName, `cultures`.id as id FROM seeds INNER JOIN cultures ON `seeds`.culture_id = `cultures`.id WHERE `seeds`.farm_id = ".$_SESSION["user_farm"]." GROUP BY cultures.`name` ORDER BY cultures.`name` ASC"); 			
	$totalArea = 0;
	foreach ($cultures as $key => $culture) {
		$cultureArea = $db->query("SELECT sum(`fields`.area) as area FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE culture_id = ".$culture["id"]." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
		$totalArea += round($cultureArea[0]["area"], 2);

		echo "<a href=\"\" class=\"show\" data-id=\"".$culture['id']."\" data-type=\"culture\"><h2>".$culture['tableName']." ".round($cultureArea[0]["area"], 2)." ha</h2></a>";
		echo "<table>";
			$color = 1;
			$seeds = $db->query("SELECT id, `name` FROM seeds WHERE farm_id = ".$_SESSION["user_farm"]." and culture_id = ".$culture['id']." ORDER BY `name` ASC"); 		
			foreach ($seeds as $key => $seed) {
				$seedArea = $db->query("SELECT sum(`fields`.area) as area FROM `fields` LEFT OUTER JOIN seedings ON `fields`.id = `seedings`.`field_id` WHERE seed_id = ".$seed["id"]." and season_id = ".$_SESSION["user_season"]." and `fields`.farm_id = ".$_SESSION["user_farm"].";"); 
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableSingle show" data-id="'.@$seed['id'].'" data-type="seed"><a href="" class="aStyle">'.@$seed['name'].' <strong>'.round($seedArea[0]["area"], 2).' ha</strong></a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
					}
					echo '<td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableSingle second show" data-id="'.@$seed['id'].'" data-type="seed"><a href="" class="aStyle">'.@$seed['name'].' <strong>'.round($seedArea[0]["area"], 2).' ha</strong></a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
					if ($_SESSION["user_rights"] >= 16){
						echo '<img src="img/delete.png" class="delete" data-id="'.@$seed['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
					}
					echo '<td>';
					echo '</tr>';
				}
			}

		echo "</table>";


  }

  	echo "<h2>".$Text->getText("seeds_total_area").": ".$totalArea." ha</h2>";
  ?> 
</div>
<script type="text/javascript">
	$('.addButton').click(function(){
	    var file = "pages/seeds/views/addSeed.php"
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


  $('.show').click(function(){
  	var page = $(this).data('type');
  	page = page.charAt(0).toUpperCase() + page.slice(1);

	var file = "pages/seeds/views/show"+page+".php?id="+$(this).data('id');   
    var file2 = "markWorkFields.php?workType="+$(this).data('type')+"&workID="+$(this).data('id');
	
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
    if (confirm(<?php echo "\"".$Text->getText("seeds_message_delete")."\""; ?>)) {    	
	    var url = "pages/seeds/actions/deleteSeed.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/seeds/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	      });
    }
    return false;
  });
</script>