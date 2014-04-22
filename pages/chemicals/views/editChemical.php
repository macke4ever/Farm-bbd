<!-- @$_GET['id'] -->
<?php

		include "../../../dbConfig.php";	
		//var_dump($_GET);   
		$r = mysql_query("SELECT * FROM chemicals where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
			 
		$chemicals = $db->query("SELECT * FROM chemicals where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
			 
		if (!empty($chemicals)) {
			$chemtypes = $db->query("SELECT name FROM chemtypes where id = ".@$chemicals[0]['chemtype_id']);

			if (!empty($chemtypes)) {
				$chemicals[0]["chemtype"] = $chemtypes[0]['name'];			 
			} 
		}			


	    $chemtypes = $db->query("SELECT * FROM chemtypes ORDER BY name ASC");
?>  

<h1>Redaguoti priežiūros priemonę</h1>
<form id="changeChemical" action="pages/chemicals/actions/changeChemical.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Rūšis</td>
			<td class="tableRight">
				<select name="chemtype_id" id="chemtype_id" data-placeholder="Pasirinkite tipą" style="width:261px;">
	                <?php 
                        echo '<option value="0" selected></option>';
	                    foreach($chemtypes as $key => $chemtype){
	                    	if ($chemtype['id'] == $chemicals[0]['chemtype_id']) {
	                    		echo '<option value="'.$chemtype['id'].'" selected>'.$chemtype["name"].'</option>';
	                    	} else {
	                        	echo '<option value="'.$chemtype['id'].'">'.$chemtype["name"].'</option>';                            
	                    	}
                        }
	                ?>
	              </select>
			</td>
		</tr>
		<tr>
			<td class="tableLeft second">Pavadinimas</td>
			<td class="tableRight second"><input type="text" name="name" id="name" value=<?php echo '"'.$chemicals[0]["name"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft">Turėta</td>
			<td class="tableRight"><input type="text" name="startQuantity" id="startQuantity" value=<?php echo '"'.$chemicals[0]["startQuantity"].'"'; ?> style="width: 100px;"></td>
		</tr>
		<tr>
			<td class="tableLeft second">Kiekis</td>
			<td class="tableRight second"><input type="text" name="quantity" id="quantity" value=<?php echo '"'.$chemicals[0]["quantity"].'"'; ?> style="width: 100px;"></td>
		</tr>
		<tr>
			<td class="tableLeft">Vnt. kaina</td>
			<td class="tableRight"><input type="text" name="price" id="price" value=<?php echo '"'.$chemicals[0]["price"].'"'; ?> style="width: 50px;">Lt</td>
		</tr>
		<tr>
			<td class="tableLeft">Mato vnt.</td>
			<td class="tableRight"><input type="text" name="measure" id="measure" value=<?php echo '"'.$chemicals[0]["measure"].'"'; ?> style="width: 50px;"></td>
		</tr>
		<tr>
		    <td class="tableLeft second"><input type="submit" id="submit" name="submit" value="Saugoti"/></td>
			<td class="tableRight second"><input type="hidden" id="id" name="id" value=<?php echo '"'.$chemicals[0]["id"].'"'; ?>/><button id="cancel" data-chemical=<?php echo '"'. @$_GET['id']. '"'; ?>>Atgal</button></td>
		</tr>
	</table>
</form>

<script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#changeChemical").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, { name: $('#name').val(), chemtype_id: $('#chemtype_id').val(), measure: $('#measure').val(), quantity: $('#quantity').val(), startQuantity: $('#startQuantity').val(), id: $('#id').val(), price: $('#price').val() } );

      $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/chemicals/views/showChemical.php?id='.@$_GET["id"].'";' ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });

    $('#cancel').click(function(){
	    var file = "pages/chemicals/views/showChemical.php?id="
		file += $(this).data('chemical');
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});
</script>


<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#chemtype_id").chosen();
      $("#chemtype_id").chosen({allow_single_deselect:true});
</script>
