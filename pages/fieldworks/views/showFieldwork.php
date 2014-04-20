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
		    <td class="tableLeft">Plotas</td>
			<td class="tableRight"><?php echo $area; ?> ha</td>
		</tr>
		<tr>
		    <td class="tableLeft"><button type="button" class="buttonChange" data-fieldwork=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>
</div>

<?php 
	echo "<h2>Išdirbti laukai</h2>";	
	echo "<table class='fieldsList'>";	
	foreach ($fieldworkAreas as $key => $field) {
		$coord = "";
		if ($field["coordinates"] == ""){
			$coord = "color: red;";
		}
		if ($color == 1) {
			$color = 2;
			echo '<tr>';
			echo '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href="">';
			echo '<td>';
			echo '</tr>';
		} else {
			$color = 1;
			echo '<tr>';
			echo '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href="">';
			echo '<td>';
			echo '</tr>';
		}				
	}

	echo "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>Bendras išdirbtas plotas: ".$area." ha</td><td class='tableSingle second'></td></tr>";
	echo "<tr><td class='tableSingle second' style='padding-top: 5px; font-weight: bold;'>Sunaudota kuro: ".$area*$fieldwork[0]['consumption']." l</td><td class='tableSingle second'></td></tr>";
	echo "</table>";

 ?>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    var file = "pages/fieldworks/views/editFieldwork.php?id="
		file += $(this).data('fieldwork');
		
		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

	// $('#cancel').click(function(){
 //     	resetMaps();
 //        var file = "pages/fieldworks/index.php";
		
	// 	$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
        
 //        $.get(file, function(data){
 //            $('#content').html(data);
 //          });
 //        return false;
 //    });


    $('#cancel').click(function(){
     // console.log('aa');

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

    $('.show').click(function(){
	    var file = "pages/fields/views/showField.php?back=showfieldwork&bid="+<?php echo @$_GET['id']; ?>+"&id="
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    resetMaps();
	    paryskinti2($(this).data('field'));
	    return false;
	});
</script>