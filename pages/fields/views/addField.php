<h1>Pridėti naują lauką</h1>
<form id="fieldForm" action="pages/fields/actions/addFieldSQL.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Pavadinimas</td>
			<td class="tableRight"><input type="text" name="name" id="name" style="width: 261px;" tabindex="2"></td>
		</tr>
		<tr>
			<td class="tableLeft">Plotas</td>
			<td class="tableRight"><input type="text" name="area" id="area" style="width: 100px;" tabindex="3"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Saugoti" tabindex="4"/></td>
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

      /* Put the results in a div */
      posting.done(function( data ) {
        // alert('success');
        <?php echo 'var file = "pages/fields/index.php";'; ?>

        //update main content in the page - sqitch menu
        $.get(file, function(data){$('#content').html(data);});   

      });
    });
</script>
