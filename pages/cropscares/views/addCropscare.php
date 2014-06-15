<?php 
  include_once "../../../class.text.php";
?>

<h1><?php echo $Text->getText("cropscares_add"); ?></h1>
<form id="cropscaresForm" action="pages/cropscares/actions/addCropscareSQL.php" method="post">
	<table>
		<tr>
      <td class="tableLeft"><?php echo $Text->getText("form_name"); ?></td>
      <td class="tableRight"><input type="text" name="name" id="name" style="width: 261px;" tabindex="2"></td>
    </tr>
    <tr>
			<td class="tableLeft second"><?php echo $Text->getText("form_fuel"); ?></td>
			<td class="tableRight second"><input type="text" name="consumption" id="consumption" style="width: 261px;" tabindex="3"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="<?php echo $Text->getText("form_save"); ?>" tabindex="4"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>


<script type="text/javascript">
	 /* attach a submit handler to the form */
   	$("#cropscaresForm").submit(function(event) {
      /* stop form from submitting normally */
      
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, {name: $('#name').val(), consumption: $('#consumption').val() } );

      $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
      
      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/cropscares/index.php";'; ?>
        $.get(file, function(data){$('#content').html(data);});
      });
    });
</script>
