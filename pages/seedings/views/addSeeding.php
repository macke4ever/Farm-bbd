<?php 
  include_once "../../../dbConfig.php";
  $cultures = $db->query("SELECT * FROM seeds inner join cultures on `seeds`.culture_id = `cultures`.id where farm_id = ".$_SESSION["user_farm"]." group by `seeds`.culture_id"); 

?>


<div id="seedingsModify">
  <h1>Sėja</h1>
  <form id="fieldworkForm" action="pages/seedings/actions/addFieldworkSQL.php" method="post">
  	<table>
      <tr>
        <td class="tableLeft">Veislė</td>
        <td class="tableRight"><select name="seed" id="selectSeed" data-placeholder="Pasirinkite veislę" style="width:261px;">
            <option value="0"></option>  
          <?php 
              foreach ($cultures as $key => $culture) {
                $seeds = $db->query('SELECT * from seeds where culture_id = '.$culture['id'].' and farm_id = 4');
                if (sizeof($seeds) > 0) {
                  echo '<optgroup label="'.$culture['name'].'">';
                  foreach ($seeds as $key => $seed) {
                    echo '<option value="'.$seed['id'].'">'.$seed['name'].'</option>';
                  }
                  echo '</optgroup>';
                }
              }
           ?>
        </td>
      </tr>
  		<tr>
        <td class="tableLeft second">Norma kg/ha</td>
        <td class="tableRight second"><input type="text" name="quantity" id="quantity" style="width: 261px;" tabindex="1"></td>
      </tr>
  		<tr>
  		    <td class="tableLeft"><button id="cancel">Atgal</button></td>
  			<td class="tableRight"></td>
  		</tr>
  	</table>
  </form>


  <script type="text/javascript">
  	 /* attach a submit handler to the form */
     	$("#fieldworkForm").submit(function(event) {

        /* stop form from submitting normally */
        
        event.preventDefault();

        /* get some values from elements on the page: */
        var $form = $( this ),
            url = $form.attr( 'action' );

        /* Send the data using post */
        var posting = $.post( url, {quantity: $('#quantity').val() } );

        /* Put the results in a div */
        posting.done(function( data ) {
          // alert('success');
          <?php echo 'var file = "pages/seedings/index.php";'; ?>
          $.get(file, function(data){$('#content').html(data);});
        });
      });

    $('#cancel').click(function(){
     console.log('aa');
        var file = "pages/seedings/index.php";
        $.get(file, function(data){
            $('#content').html(data);
          });
        return false;
    });
  </script>

  <script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
  <script type='text/javascript'> 
        $("#selectSeed").chosen();
        $("#selectSeed").chosen({allow_single_deselect:true});
  </script>
</div>