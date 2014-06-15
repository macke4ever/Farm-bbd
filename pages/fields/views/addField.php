<?php 

  include_once "../../../class.text.php";

 ?>

<h1><?php echo $Text->getText("fields_add"); ?></h1>
<form id="fieldForm" action="pages/fields/actions/addFieldSQL.php" method="post">
	<table>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("form_name"); ?></td>
			<td class="tableRight"><input type="text" name="name" id="name" style="width: 261px;" tabindex="2"></td>
		</tr>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("form_area"); ?></td>
			<td class="tableRight"><input type="text" name="area" id="area" style="width: 100px;" tabindex="3"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="<?php echo $Text->getText("form_save"); ?>" tabindex="4"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	 /* attach a submit handler to the form */
   	$("#fieldForm").submit(function(event) {

      
      /* stop form from submitting normally */
      
      event.preventDefault();

      /* get some values from elements on the page: */
      var $form = $( this ),
          url = $form.attr( 'action' );

      /* Send the data using post */
      var posting = $.post( url, {name: $('#name').val(), area: $('#area').val() } );

      $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
      
      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/fields/index.php";'; ?>

        //update main content in the page - sqitch menu
        $.get(file, function(data){$('#content').html(data);});   

      });
    });
</script>
