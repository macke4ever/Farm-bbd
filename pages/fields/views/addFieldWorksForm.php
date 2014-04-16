<?php 
	
    $fieldworksList = $db->query("SELECT * FROM fieldworks ORDER BY name ASC");

    $cropscaresList = $db->query("SELECT * FROM caresets ORDER BY name ASC");

?>
<h2>Darbų pridėjimas</h2>
<form id="addWorkToField" action="pages/fields/actions/addWorkToField.php" method="post">
		<select name="fieldwork_id" id="fieldwork_id" data-placeholder="Pasirinkite žemės dirbimą" style="width:100%;">
        <?php 
            echo '<option value="0" selected></option>';
            foreach($fieldworksList as $key => $fieldworkList){
                echo '<option value="'.$fieldworkList['id'].'">'.$fieldworkList["name"].'</option>';                            
            }
        ?>
        </select>
		<input type="date" name="date" id="date" placeholder="yyyy-mm-dd">
		<input type="hidden" name="field_id" id="field_id" value=<?php echo '"'.@$_GET['id'].'"' ?>>
		<input type="hidden" name="workType" id="workType" value="fieldWork">
		<input type="submit" value="Pridėti žemės dirbimą">
</form>

<form id="addCropsCareToField" action="pages/fields/actions/addWorkToField.php" method="post">
		<select name="cropscare_id" id="cropscare_id" data-placeholder="Pasirinkite priežiūros darbą" style="width:100%;">
        <?php 
            echo '<option value="0" selected></option>';
            foreach($cropscaresList as $key => $cropscareList){
                echo '<option value="'.$cropscareList['id'].'">'.$cropscareList["name"].'</option>';                            
            }
        ?>
        </select>
		<input type="date" name="date2" id="date2" placeholder="yyyy-mm-dd">
		<input type="hidden" name="field_id2" id="field_id2" value=<?php echo '"'.@$_GET['id'].'"' ?>>
		<input type="hidden" name="workType2" id="workType2" value="cropscare">
		<input type="submit" value="Pridėti priežiūros darbą">
</form>



<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#fieldwork_id").chosen();
      $("#fieldwork_id").chosen({allow_single_deselect:true}); 
      $("#cropscare_id").chosen();
      $("#cropscare_id").chosen({allow_single_deselect:true});



    $("#addWorkToField").submit(function(event) {
	      /* stop form from submitting normally */
	      event.preventDefault();
	      /* get some values from elements on the page: */
	     var $form = $( this ),
	         url = $form.attr( 'action' );
	      /* Send the data using post */
	     var posting = $.post( url, { date: $('#date').val(), field_id: $('#field_id').val(), id: $('#fieldwork_id').val(), workType: $('#workType').val() } );
	     
	     $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

	      /* Put the results in a div */
	     posting.done(function( data ) {
	       <?php echo 'var file = "pages/fields/views/showField.php?id='.@$_GET["id"].'";' ?>
	       $.get(file, function(data){$('#content').html(data);});
	    });
    });


	$("#addCropsCareToField").submit(function(event) {
        /* stop form from submitting normally */
		event.preventDefault();
		/* get some values from elements on the page: */
		var $form = $( this ),
		url = $form.attr( 'action' );
		/* Send the data using post */
		var posting = $.post( url, { date: $('#date2').val(), field_id: $('#field_id2').val(), id: $('#cropscare_id').val(), workType: $('#workType2').val() } );
       
        $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

		/* Put the results in a div */
		posting.done(function( data ) {
			<?php echo 'var file = "pages/fields/views/showField.php?id='.@$_GET["id"].'";' ?>
			$.get(file, function(data){$('#content').html(data);});
		});
	});		
</script>