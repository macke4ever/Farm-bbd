<!-- @$_GET['id'] -->
<?php

		include_once "../../../dbConfig.php";
		$fieldwork = $db->query("SELECT * FROM fieldworks where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		

?>  

<h1>Redaguoti dirbimą</h1>
<form id="changeFieldwork" action="pages/fieldworks/actions/changeFieldwork.php" method="post">
	<table>
		<tr>
			<td class="tableLeft ">Pavadinimas</td>
			<td class="tableRight "><input type="text" name="name" id="name" value=<?php echo '"'.$fieldwork[0]["name"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft second">L/ha</td>
			<td class="tableRight second"><input type="text" name="consumption" id="consumption" value=<?php echo '"'.$fieldwork[0]["consumption"].'"'; ?> style="width: 261px;"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Saugoti"/></td>
			<td class="tableRight"><input type="hidden" id="id" name="id" value=<?php echo '"'.$fieldwork[0]["id"].'"'; ?>/><button id="cancel" data-fieldwork=<?php echo '"'. @$_GET['id']. '"'; ?>>Atgal</button></td>
		</tr>
	</table>
</form>

<script type='text/javascript'>

    /* attach a submit handler to the form */
    $("#changeFieldwork").submit(function(event) {

      /* stop form from submitting normally */
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

       //Send the data using post 
       console.log($('#name').val());
      var posting = $.post( url, { name: $('#name').val(), consumption: $('#consumption').val(), id: $('#id').val() } );
      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/fieldworks/views/showFieldwork.php?id='.@$_GET["id"].'";' ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });

    $('.cancel').click(function(){
	    var file = "pages/fieldworks/views/showFieldwork.php?id="
		file += $(this).data('fieldwork');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});
</script>
