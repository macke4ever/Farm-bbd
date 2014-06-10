<!-- @$_GET['id'] -->
<?php

		include_once "../../../dbConfig.php";
		$fieldwork = $db->query("SELECT * FROM fieldworks where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		

		$fieldworkAreas = $db->query("SELECT `fields`.area as area, `fields`.name as name, `fields`.coordinates as coordinates, `fields`.id as id FROM fieldworks_fields LEFT OUTER JOIN `fields` ON `fieldworks_fields`.`field_id` = `fields`.id  WHERE fieldwork_id = ".$_GET["id"]." ORDER BY `fields`.name ASC;"); 
		
		$area = 0;
		foreach ($fieldworkAreas as $key => $value) {
			$area += $value["area"];
		}
			 	
?>  

<div id="fieldwork-view">	
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
		    <td class="tableLeft">Plotas</td>
			<td class="tableRight" id="area"><?php echo $area; ?> ha</td>
		</tr>
		<tr>
		    <td class="tableLeft"><button type="button" class="buttonChange" data-fieldwork=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>
</div>

<div>
	<h2>Laukų pridėjimas</h2>
	<table>
		<tr>
		    <td class="tableLeft" title="Leisti pridėti laukus prie darbo">Įgalinti</td>
			<td class="tableRight"><input type="checkbox" name="enableAdd" id="enableAdd"></td>
		</tr>
		<tr>
		    <td class="tableLeft second" title="Darbo atlikimo data">Data</td>
			<td class="tableRight second"><input type="date" name="date" id="date" placeholder="yyyy-mm-dd"></td>
			<input type="hidden" name="fieldworkID" value=<?php echo '"'.@$_GET['id'].'"'; ?> id="fieldworkID">
		</tr>
	</table>
</div>

<div id="fieldsReturn">
	<!-- <?php include "doneFields.php"; ?> -->
</div>

<script type="text/javascript">
	
	function updateFieldsReturn(){
		$.get('pages/fieldworks/views/doneFields.php'+<?php echo "'?id=".@$_GET['id']."&consumption=".@$fieldwork[0]['consumption']."'"; ?>, function(data){
	        // console.log(data);
	        data = JSON.parse(data);
	        $('#area').html(data.area);
	        $('#fieldsReturn').html(data.fieldsReturn);
	        $('.show').bind("click", showField);
      	});
	    return false;
	};

	updateFieldsReturn();

    function showField() {
    	// alert("aa");
	    var file = "pages/fields/views/showField.php?back=showfieldwork&bid="+<?php echo @$_GET['id']; ?>+"&id=";
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    paryskinti2($(this).data('field'));
	    keistiCentra($(this).data('field'));
	    return false;
	};

	$('.buttonChange').click(function(){
	    var file = "pages/fieldworks/views/editFieldwork.php?id="
		file += $(this).data('fieldwork');
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


    $('#cancel').click(function(){
     //prideta visokios logikos kad butu galima gristi i ankstesni puslapi pagal tai is kur buvo ateita
     //kadangi jau galima perziureti lauka ne tik is lauku saraso bet ir is apsetu lauku tam tikra veisle saraso
        resetMaps();
	    <?php 
	     	if (!empty($_GET["back"])){
	     		if ($_GET["back"] == "showfield"){
		     		echo 'var file = "pages/fields/views/showField.php?id='.$_GET["bid"].'";';
		     		echo 'paryskinti2('.$_GET["bid"].');';
	     		}
		     		echo '$(\'#content\').html("<center><img src=\'img/ajax-loader.gif\' style=\'padding-top: 50px;\'></center>");';
					echo '$.get(file, function(data){$(\'#content\').html(data);});';
	     	} else {	
	        	echo 'var file = "pages/fieldworks/index.php";';
	        	echo '$(\'#content\').html("<center><img src=\'img/ajax-loader.gif\' style=\'padding-top: 50px;\'></center>");';
	        	echo '$.get(file, function(data){$(\'#content\').html(data);});';
	     	}
	    ?>
        return false;
    });

</script>