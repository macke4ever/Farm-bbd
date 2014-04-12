<!-- @$_GET['id'] -->
<?php

	include_once "../../../dbConfig.php";	  
	$seeds = $db->query("SELECT * FROM seeds where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
		 
	if (!empty($seeds)) {
		$cultures = $db->query("SELECT name FROM cultures where id = ".@$seeds[0]['culture_id']);

		if (!empty($cultures)) {
			$seeds[0]["culture"] = $cultures[0]['name'];			 
		} 
	}		


    $cultures = $db->query("SELECT * FROM cultures");

?>  

<h1>Redaguoti veislę</h1>
<form id="changeSeed" action="pages/seeds/actions/changeSeed.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Kultūra</td>
			<td class="tableRight">
				<select name="culture_id" id="culture_id" data-placeholder="Pasirinkite kultūrą" style="width:261px;">
	                <?php 
                        echo '<option value="0" selected></option>';
	                    foreach($cultures as $key => $culture){
	                    	if ($culture['id'] == $seeds[0]['culture_id']) {
	                    		echo '<option value="'.$culture['id'].'" selected>'.$culture["name"].'</option>';
	                    	} else {
	                        	echo '<option value="'.$culture['id'].'">'.$culture["name"].'</option>';                            
	                    	}
                        }
	                ?>
	              </select>
			</td>
		</tr>
		<tr>
			<td class="tableLeft second">Pavadinimas</td>
			<td class="tableRight second"><input type="text" name="name" id="name" value=<?php echo '"'.$seeds[0]["name"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft">Kiekis</td>
			<td class="tableRight"><input type="text" name="quantity" id="quantity" value=<?php echo '"'.$seeds[0]["quantity"].'"'; ?> style="width: 50px;">&nbsp;t.</td>
		</tr>
		<tr>
		    <td class="tableLeft second"><input type="submit" id="submit" name="submit" value="Saugoti"/></td>
			<td class="tableRight second"><input type="hidden" id="id" name="id" value=<?php echo '"'.$seeds[0]["id"].'"'; ?>/><button id="cancel" data-seed=<?php echo '"'. @$_GET['id']. '"'; ?>>Atgal</button></td>
		</tr>
	</table>
</form>

<script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#changeSeed").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, { name: $('#name').val(), culture_id: $('#culture_id').val(), quantity: $('#quantity').val(), id: $('#id').val() } );

      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/seeds/views/showSeed.php?id='.@$_GET["id"].'";' ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });

    $('#cancel').click(function(){
	    var file = "pages/seeds/views/showSeed.php?id="
		file += $(this).data('seed');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});
</script>


<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#culture_id").chosen();
      $("#culture_id").chosen({allow_single_deselect:true});
</script>
