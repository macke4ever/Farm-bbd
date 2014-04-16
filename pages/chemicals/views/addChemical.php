<?php
	include "../../../dbConfig.php";

    $r = mysql_query("SELECT * FROM chemtypes ORDER BY name ASC");
    $chemtypes = array();
    while($chemtype = mysql_fetch_assoc($r)){
        $chemtypes[$chemtype['id']] = $chemtype;
    }
?>

<h1>Pridėti naują priežiūros priemonę</h1>
<form id="chemicalForm" action="pages/chemicals/actions/addChemicalSQL.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Tipas</td>
			<td class="tableRight">
				<select name="chemtype_id" id="chemtype_id" data-placeholder="Pasirinkite priemonės tipą" style="width:261px;" tabindex="1">
	                <?php 
                        echo '<option value="0" selected></option>';
	                    foreach($chemtypes as $key => $chemtype){
	                        echo '<option value="'.$chemtype['id'].'">'.$chemtype["name"].'</option>';                            
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
			<td class="tableRight"><input type="text" name="quantity" id="quantity" style="width: 100px;" tabindex="3"></td>
		</tr>
		<tr>
			<td class="tableLeft">Mato vnt.</td>
			<td class="tableRight"><input type="text" name="mesure" id="measure" style="width: 50px;" tabindex="4"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Saugoti" tabindex="4"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>


<script type="text/javascript">
	 /* attach a submit handler to the form */
   	$("#chemicalForm").submit(function(event) {
      /* stop form from submitting normally */
      
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, {name: $('#name').val(), chemtype_id: $('#chemtype_id').val(), quantity: $('#quantity').val(), measure: $('#measure').val() } );

	  $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
      
      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/chemicals/index.php";'; ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });
</script>

<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#chemtype_id").chosen();
      $("#chemtype_id").chosen({allow_single_deselect:true});
</script>
