<!-- @$_GET['id'] -->
<?php

		include "../../../dbConfig.php";	
		//var_dump($_GET);   
		$chemicals = $db->query("SELECT * FROM chemicals where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
			 
		if (!empty($chemicals)) {
			$chemtypes = $db->query("SELECT name FROM chemtypes where id = ".@$chemicals[0]['chemtype_id']);

			if (!empty($chemtypes)) {
				$chemicals[0]["chemtype"] = $chemtypes[0]['name'];			 
			} 
		}		

?>  

<div id="chemical">	
	<h1>Priežiūros priemonės informacija</h1>
	<table>
		<tr>
		    <td class="tableLeft">Tipas</td>
			<td class="tableRight"><?php echo @$chemicals[0]['chemtype']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">Pavadinimas</td>
			<td class="tableRight second"><?php echo @$chemicals[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft">Kiekis</td>
			<td class="tableRight"><?php echo @$chemicals[0]['quantity']." ".@$chemicals[0]['measure']."."; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php if ($_SESSION["user_rights"] >= 16){ ?><button type="button" class="buttonChange" data-chemical=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button><?php } ?></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/chemicals/views/editChemical.php?id="
		file += $(this).data('chemical');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('#cancel').click(function(){
	    var file = "pages/chemicals/index.php"
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

</script>