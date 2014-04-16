<?php
	include_once "../../../dbConfig.php";	  
	$cultures = $db->query("SELECT * FROM cultures");
?>

<h1>Pridėti naują veislę</h1>
<form id="seedForm" action="pages/seeds/actions/addSeedSQL.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Kultūra</td>
			<td class="tableRight">
				<select name="culture_id" id="culture_id" data-placeholder="Pasirinkite kultūrą" style="width:261px;" tabindex="1">
	                <?php 
                        echo '<option value="0" selected></option>';
	                    foreach($cultures as $key => $culture){
	                        echo '<option value="'.$culture['id'].'">'.$culture["name"].'</option>';                            
                        }
	                ?>
	              </select>
			</td>
		</tr>
		<tr>
			<td class="tableLeft">Pavadinimas</td>
			<td class="tableRight"><input type="text" name="name" id="name" style="width: 261px;" tabindex="2"></td>
		</tr>
		<tr>
			<td class="tableLeft">Kiekis</td>
			<td class="tableRight"><input type="text" name="quantity" id="quantity" style="width: 50px;" tabindex="3">&nbsp;t.</td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Saugoti" tabindex="4"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>


<script type="text/javascript">
	 /* attach a submit handler to the form */
   	$("#seedForm").submit(function(event) {

      /* stop form from submitting normally */
      
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, {name: $('#name').val(), culture_id: $('#culture_id').val(), quantity: $('#quantity').val() } );
		
	  $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/seeds/index.php";'; ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });
</script>

<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#culture_id").chosen();
      $("#culture_id").chosen({allow_single_deselect:true});
</script>
