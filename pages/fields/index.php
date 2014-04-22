<div id="fields">
<?php 		
	include "../../dbConfig.php";
	$fields = $db->query("SELECT  name, id, coordinates, area FROM fields WHERE farm_id = '".$_SESSION["user_farm"]."' order by name asc"); 	 
	echo '<h1>Laukai</h1>';
	if ($_SESSION["user_rights"] >= 16) {
		echo '<a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;">';
	}
	echo '</a>';
	if (!empty($fields)) {
		$color = 1;	
		echo "<table class='fieldsList'>";	
		$area = 0;	
		foreach ($fields as $key => $field) {
			$coord = "";
			$area += @$field['area'];
			if ($field["coordinates"] == ""){
				$coord = "color: red;";
			}
			if ($color == 1) {
				$color = 2;
				echo '<tr>';
				echo '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
				echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
				if ($_SESSION["user_rights"] >= 16){
					echo '<img src="img/delete.png" class="delete" data-id="'.@$field['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
				}
				echo '<td>';
				echo '</tr>';
			} else {
				$color = 1;
				echo '<tr>';
				echo '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
				echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
				if ($_SESSION["user_rights"] >= 16){
					echo '<img src="img/delete.png" class="delete" data-id="'.@$field['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a>';
				}
				echo '<td>';
				echo '</tr>';
			}				
		}

		echo "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>Bendras plotas: ".$area." ha</td><td class='tableSingle second'></td></tr>";
		echo "</table>";
	}
 ?>	
</div>

<script type="text/javascript">
	$('.addButton').click(function(){
	    var file = "pages/fields/views/addField.php"
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/fields/views/showField.php?id="
		file += $(this).data('field');
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    paryskinti2($(this).data('field'));
	    keistiCentra($(this).data('field'));
	    return false;
	});


$('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą lauką?\n\nKartu bus pašalinta visa su juo susijusi informacija: žemės darbai, sėja, pasėlių priežiūra, visų metų darbų istorija.")) {    	
	    var url = "pages/fields/actions/deleteField.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

	      /* Put the results in a div */
	      posting.done(function( data ) {
	        var file = "pages/fields/index.php";
	        $.get(file, function(data){$('#content').html(data);});
	        reloadMaps();
	      });
    }
    return false;
  });
</script>