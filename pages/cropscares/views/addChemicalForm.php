<?php 
	
    $chemicalsList = $db->query("SELECT * FROM chemicals where `farm_id` = ".$_SESSION["user_farm"]."");


?>
<h2>Darbų pridėjimas</h2>
<form id="addChemicalToCropscare" action="pages/cropscares/actions/addChemicalToCropscare.php" method="post">
		<select name="chemical_id" id="chemical_id" data-placeholder="Pasirinkite chemikalą" style="width:100%;">
        <?php 
            echo '<option value="0" selected></option>';
            foreach($chemicalsList as $key => $chemicalList){
                echo '<option value="'.$chemicalList['id'].'">'.$chemicalList["name"].', '.$chemicalList["measure"].'</option>';                            
            }
        ?>
        </select>
		<input type="text" name="quantity" id="quantity" placeholder="kiekis" style="width: 100px; margin-left: 5px;"><?php echo "<span id='measure'> mato vnt.</span>"; ?>
		<input type="hidden" name="careset_id" id="careset_id" value=<?php echo '"'.@$_GET['id'].'"' ?>>
		<input type="submit" value="Pridėti ckemikalą" style="float: right; margin-right: 5px;">
</form>

<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#chemical_id").chosen();
      $("#chemical_id").chosen({allow_single_deselect:true}); 
</script>

<script type="text/javascript">
 //    $('#addChemicalToCropscare').on('change', function() {
	//   alert( $('#chemical_id').val() ); // or $(this).val()
	// });

    $("#addChemicalToCropscare").submit(function(event) {
	      /* stop form from submitting normally */
	      event.preventDefault();
	      /* get some values from elements on the page: */
	     var $form = $( this ),
	         url = $form.attr( 'action' );
	      /* Send the data using post */
	     var posting = $.post( url, { quantity: $('#quantity').val(), careset_id: $('#careset_id').val(), chemical_id: $('#chemical_id').val() }, function(result){
		    	//response text spausdinimas is to failo i kuri kreipiamasi su post
		    	var response = result;

		    	//uncomment following line to show response text from .post function target
		    	// console.log(response);
		    });

	      /* Put the results in a div */
	     posting.done(function( data ) {
	       <?php echo 'var file = "pages/cropscares/views/editCropscare.php?id='.@$_GET["id"].'";' ?>
	       $.get(file, function(data){$('#content').html(data);});
	    });
    });	
</script>