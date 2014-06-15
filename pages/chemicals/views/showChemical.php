<!-- @$_GET['id'] -->
<?php

		include "../../../dbConfig.php";	
		include "../../../class.text.php";	
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
	<h1><?php echo $Text->getText("chemicals_info"); ?></h1>
	<table>
		<tr>
		    <td class="tableLeft"><?php echo $Text->getText("chemicals_type"); ?></td>
			<td class="tableRight"><?php echo @$chemicals[0]['chemtype']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second"><?php echo $Text->getText("form_name"); ?></td>
			<td class="tableRight second"><?php echo @$chemicals[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php echo $Text->getText("form_total_quantity"); ?></td>
			<td class="tableRight"><?php echo @$chemicals[0]['startQuantity']." ".@$chemicals[0]['measure']."."; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second"><?php echo $Text->getText("form_quantity"); ?></td>
			<td class="tableRight second"><?php echo @$chemicals[0]['quantity']." ".@$chemicals[0]['measure']."."; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php echo $Text->getText("form_measure"); ?></td>
			<td class="tableRight"><?php echo @$chemicals[0]['price']." Lt/".@$chemicals[0]['measure']."."; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php if ($_SESSION["user_rights"] >= 16){ ?><button type="button" class="buttonChange" data-chemical=<?php echo '"'. @$_GET['id']. '"'; ?>><?php echo $Text->getText("form_edit"); ?></button><?php } ?></td>
			<td class="tableRight"><button id="cancel"><?php echo $Text->getText("form_back"); ?></button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/chemicals/views/editChemical.php?id="
		file += $(this).data('chemical');
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	$('#cancel').click(function(){
	    var file = "pages/chemicals/index.php"
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

</script>