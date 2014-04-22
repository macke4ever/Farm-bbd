<!-- @$_GET['id'] -->
<?php

		include "../../../dbConfig.php";	   
		$field = $db->query("SELECT
			`fields`.`name` as name,
			`fields`.area as area,
			`laikina`.culture_id,
			cultures.`name` as culture,
			`seeds`.name as seed,
			`tempHarvest`.`date` as harvesting,
			`laikina`.`quantity` as quantity,
			`laikina`.`comment` as season_comment,
			`fields`.comment as comment
			FROM 
			`fields` 
			LEFT JOIN (SELECT * FROM seedings WHERE farm_id = '".$_SESSION["user_farm"]."' AND season_id = '".$_SESSION["user_season"]."') as laikina ON `fields`.id = `laikina`.field_id
			LEFT JOIN cultures ON `laikina`.culture_id = `cultures`.id
			LEFT JOIN seeds ON `laikina`.seed_id = `seeds`.id
			LEFT JOIN (SELECT * FROM harvestings where season_id = '".$_SESSION["user_season"]."' and farm_id = '".$_SESSION["user_farm"]."') as tempHarvest ON `fields`.id = `tempHarvest`.field_id
			WHERE
			`fields`.id = '".@$_GET['id']."' AND
			`fields`.farm_id = ".$_SESSION["user_farm"]."
			LIMIT 1"); 		
		$field = $field[0];	
		$field["fieldPrice"] = 0;
			
		$fieldworks = array();	 
		$seedings = $db->query("select id as id, date as date from seedings where farm_id = '".$_SESSION["user_farm"]."' and season_id = '".$_SESSION["user_season"]."' and field_id = ".@$_GET['id'].""); 		
		if(!empty($seedings)){			
			foreach ($seedings as $key => $seeding) {
				$seeding['name'] = "Sėjimas";
				$seeding['type'] = "seeding";
				array_push($fieldworks, $seeding);
			}   
		}
		$fieldwork = $db->query("SELECT fieldworks.`name` as `name`, `fieldworks_fields`.`date` as `date`, `fieldworks_fields`.id as id, `fieldworks_fields`.fieldwork_id as tid FROM `fieldworks_fields` INNER JOIN fieldworks ON `fieldworks`.id = `fieldworks_fields`.fieldwork_id WHERE `fieldworks_fields`.field_id = '".@$_GET['id']."' AND `fieldworks`.season_id = '".$_SESSION["user_season"]."' AND `fieldworks`.farm_id = '".$_SESSION["user_farm"]."';"); 		 
		if(!empty($fieldwork)){
			foreach ($fieldwork as $key => $fieldwork_one) {
				$fieldwork_one['type'] = "fieldwork";
				array_push($fieldworks, $fieldwork_one);
			}
		}
		$cropscares = $db->query("SELECT `cropscares`.`id` as `id`, `cropscares`.`date` as `date`, `caresets`.`name` as `name`, `cropscares`.`careset_id` as `tid`, `caresets`.`price` as `price` FROM cropscares INNER JOIN caresets ON `cropscares`.careset_id = `caresets`.id WHERE `caresets`.farm_id = '".$_SESSION["user_farm"]."' AND `caresets`.season_id = '".$_SESSION["user_season"]."' AND `cropscares`.field_id = ".@$_GET['id'].";"); 		 
		if(!empty($cropscares)){
			foreach ($cropscares as $key => $cropscare) {
				$cropscare['type'] = "cropscare";
				array_push($fieldworks, $cropscare);
				$field["fieldPrice"] += $cropscare["price"];
 			}
		}
		$field["fieldPrice"] = round($field["fieldPrice"], 2);

		//Masyvo rusiavimas, cia nusirodo kaip ji rusiuoti pagal data, kadangi tai yra masyvas is masyvu
		function invenDescSort($item1,$item2)
		{
		    if ($item1['date'] == $item2['date']) return 0;
		    return ($item1['date'] > $item2['date']) ? 1 : -1;
		}
		if (!empty($fieldworks)){
			usort($fieldworks,'invenDescSort');
		}
?>  

<div id="fields">	
	<h1>Lauko informacija</h1>
	<table>
		<tr>
		    <td class="tableLeft">Pavadinimas</td>
			<td class="tableRight"><?php echo @$field['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">Plotas</td>
			<td class="tableRight second"><?php echo @$field['area']." ha"; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft">Kultūra</td>
			<td class="tableRight"><?php echo @$field['culture']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">Veislė</td>
			<td class="tableRight second"><?php echo @$field['seed'].", ".@$field['quantity']." kg/ha"; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft">Nukulta</td>
			<td class="tableRight"><?php if (@$field['harvesting'] != "0000-00-00") {echo @$field['harvesting'];} ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second">Savikaina</td>
			<td class="tableRight second"><?php echo @$field['fieldPrice']." Lt/ha,  Viso: ".round($field["fieldPrice"]*$field["area"], 2). " Lt"; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft">Lauko kom.</td>
			<td class="tableRight"><?php echo @$field['comment']; ?></td>
		</tr>
		<?php 
			if (@$field['culture']) {
		?>
				<tr>
				    <td class="tableLeft second">Sezono kom.</td>
					<td class="tableRight second"><?php echo @$field['season_comment']; ?></td>
				</tr>
		<?php } ?>
		<tr>
		    <td class="tableLeft"><?php if ($_SESSION["user_rights"] >= 16){ ?><button type="button" class="buttonChange" data-field=<?php echo '"'. @$_GET['id']. '"'; ?>>Redaguoti</button><?php } ?></td>
			<td class="tableRight"><button id="cancel">Atgal</button></td>
		</tr>
	</table>

	<?php include "addFieldWorksForm.php" ?>

	<h2>Darbai lauke</h2>

	<table>
	<?php
		if (@$fieldworks){			
			$color = 1;
			foreach ($fieldworks as $key => $work) {
				if ($color == 1)
				{
					$color = 2;
					echo '<tr>';
					echo '    <td class="tableLeft">'.@$work['date'].'</td>';
					echo '	  <td class="tableRight"><a href="" data-id="'.@$work['tid'].'" data-type="'.@$work['type'].'" class="aStyle show">'.@$work['name'].'</a></td>';
					echo '	  <td class="tableSingle" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" data-type="'.@$work['type'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				} else {
					$color = 1;
					echo '<tr>';
					echo '    <td class="tableLeft second">'.@$work['date'].'</td>';
					echo '	  <td class="tableRight second"><a href="" data-id="'.@$work['tid'].'" data-type="'.@$work['type'].'" class="aStyle show">'.@$work['name'].'</a></td>';
					echo '	  <td class="tableSingle second" style="text-align: right; width: 20px;"><a href=""><img src="img/delete.png" class="delete" data-id="'.@$work['id'].'" data-type="'.@$work['type'].'" style="width: 16px; height:16px; margin: 2px 4px 0 0;"></a><td>';
					echo '</tr>';
				}
			}
		} 
	 ?>
	</table>
	<div id="garbage">&nbsp;</div>
</div>

<script type="text/javascript">
	$('.buttonChange').click(function(){
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    var file = "pages/fields/views/editField.php?id="
		file += $(this).data('field');
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});

$('.delete').click(function(){
    if (confirm("Ar tikrai norite pašalinti pasirinktą  darbą?")) {    	
	    var url = "pages/fields/actions/deleteWorkFromField.php";	
	    var posting = $.post( url, { id: $(this).data('id'),  type: $(this).data('type'), field_id: <?php echo @$_GET['id'] ?> } );

	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	      /* Put the results in a div */
	      posting.done(function( data ) {
	        <?php echo "var file = \"pages/fields/views/showField.php?id=".@$_GET['id']."\";"; ?>
	        $.get(file, function(data){
	        	$('#content').html(data);
	        });
	      });
    }
    return false;
});

    $('#cancel').click(function(){
     // console.log('aa');

     //prideta visokios logikos kad butu galima gristi i ankstesni puslapi pagal tai is kur buvo ateita
     //kadangi jau galima perziureti lauka ne tik is lauku saraso bet ir is apsetu lauku tam tikra veisle saraso
	    <?php 
	     	if (!empty($_GET["back"])){
	     		if ($_GET["back"] == "showseed"){
		     		echo 'var file = "pages/seeds/views/showSeed.php?id='.$_GET["bid"].'";';
		     		echo 'var file2 = "markWorkFields.php?workType=seed&workID='.$_GET["bid"].'";';
	     		}
	     		if ($_GET["back"] == "showfieldwork"){
		     		echo 'var file = "pages/fieldworks/views/showFieldwork.php?id='.$_GET["bid"].'";';
		     		echo 'var file2 = "markWorkFields.php?workType=fieldwork&workID='.$_GET["bid"].'";';
	     		}
	     		if ($_GET["back"] == "showcropscare"){
		     		echo 'var file = "pages/cropscares/views/showCropscare.php?id='.$_GET["bid"].'";';
		     		echo 'var file2 = "markWorkFields.php?workType=cropscare&workID='.$_GET["bid"].'";';
	     		}
		     		echo '$(\'#content\').html("<center><img src=\'img/ajax-loader.gif\' style=\'padding-top: 50px;\'></center>");';
					echo '$.get(file, function(data){$(\'#content\').html(data);});';
					echo '$.get(file2, function(data){$(\'#content2\').html(data);});';
	     	} else {	
	        	echo 'var file = "pages/fields/index.php";';
	        	echo '$(\'#content\').html("<center><img src=\'img/ajax-loader.gif\' style=\'padding-top: 50px;\'></center>");';
	        	echo '$.get(file, function(data){$(\'#content\').html(data);});';
	     	}
	    ?>
        
        resetMaps();

        return false;
    });

	$('.show').click(function(){
	    if ($(this).data('type') == "fieldwork"){
	    	<?php echo 'var file = "pages/fieldworks/views/showFieldwork.php?back=showfield&bid='.$_GET["id"].'&id=";'; ?>
			file += $(this).data('id');
	    	
	    	var file2 = "markWorkFields.php?workType=fieldwork&workID="+$(this).data('id');
	    	$.get(file2, function(data){$('#content2').html(data);});
	    }
	    if ($(this).data('type') == "cropscare"){
	    	<?php echo 'var file = "pages/cropscares/views/showCropscare.php?back=showfield&bid='.$_GET["id"].'&id=";'; ?>
			file += $(this).data('id');
	    	
	    	var file2 = "markWorkFields.php?workType=cropscare&workID="+$(this).data('id');
	    	$.get(file2, function(data){$('#content2').html(data);});
	    }
		if ($(this).data('type') == "seeding"){
			return false;
		}

		$('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    // resetMaps();
	    // paryskinti2($(this).data('field'));
	    return false;
	});


//jeigu reiktu response teksto is .post formos POST:

// $.post("/search/loadBottomLooks/", 
 // { pageNum: "2" },
 // function(responseText, responseStatus){ 
 //      alert('got into the callback!'); 
 //      $("#garbage").html(responseText);
 // });
</script>