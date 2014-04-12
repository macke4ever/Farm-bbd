<div id="fields">
<?php 		
	include "../../dbConfig.php";
	$fields = $db->query("SELECT  name, id, coordinates FROM fields WHERE farm_id = '".$_SESSION["user_farm"]."' order by name asc"); 	 
	echo '<h1>Laukai</h1><a href=""><img src="img/add.png" class="addButton" tabindex="1" style="width: 22px; height:22px; margin: 10px 15px 0 0;"></a>';
	if (!empty($fields)) {
		$color = 1;	
		echo "<table class='fieldsList'>";		
		foreach ($fields as $key => $field) {
			$coord = "";
			if ($field["coordinates"] == ""){
				$coord = "color: red;";
			}
			if ($color == 1) {
				$color = 2;
				echo '<tr>';
				echo '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
				echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$field['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
				echo '</tr>';
			} else {
				$color = 1;
				echo '<tr>';
				echo '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
				echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$field['id'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
				echo '</tr>';
			}				
		}
		echo "</table>";
	}
 ?>	
</div>

<script type="text/javascript">
	$('.addButton').click(function(){
	    var file = "pages/fields/views/addField.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('.show').click(function(){
	    var file = "pages/fields/views/showField.php?id="
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    var id = $(this).data('field');
	    resetMaps();
	    paryskinti(laukai[id]);
	    return false;
	});


$('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą lauką?\n\nKartu bus pašalinta visa su juo susijusi informacija: žemės darbai, sėja, pasėlių priežiūra, visų metų darbų istorija.")) {    	
	    var url = "pages/fields/actions/deleteField.php";	
	    var posting = $.post( url, { id: $(this).data('id') } );

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