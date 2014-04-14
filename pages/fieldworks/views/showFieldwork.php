<!-- @$_GET['id'] -->
<?php

		include_once "../../../dbConfig.php";
		$fieldwork = $db->query("SELECT * FROM fieldworks where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
			 	
?>  

<div id="fieldwork">	
	<h1>Dirbimo informacija</h1>
	<table>
		<tr>
		    <td class="tableLeft">Pavadinimas</td>
			<td class="tableRight"><?php echo @$fieldwork[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">L/ha kuro</td>
			<td class="tableRight second"><?php echo @$fieldwork[0]['consumption']; ?></td>
		</tr>

		<tr>
		    <td class="tableLeft"><button type="button" class="buttonChange" data-fieldwork=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/fieldworks/views/editFieldwork.php?id="
		file += $(this).data('fieldwork');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('#cancel').click(function(){
     // console.log('aa');
     	resetMaps();
        var file = "pages/fieldworks/index.php";
        $.get(file, function(data){
            $('#content').html(data);
          });
        return false;
    });
</script>