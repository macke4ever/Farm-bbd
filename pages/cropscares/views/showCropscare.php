<!-- @$_GET['id'] -->
<?php
		include_once "../../../dbConfig.php";
		include_once "../../../class.text.php";

		$cropscares = $db->query("SELECT * FROM caresets where id = ".@$_GET['id']." and farm_id = ".$_SESSION["user_farm"]." LIMIT 1"); 		
?>  

<div id="cropscare-view">	
	<h1><?php echo $Text->getText("cropscares_info"); ?></h1>
	<table>
		<tr>
		    <td class="tableLeft"><?php echo $Text->getText("form_name"); ?></td>
			<td class="tableRight"><?php echo @$cropscares[0]['name']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft second"><?php echo $Text->getText("form_fuel"); ?></td>
			<td class="tableRight second"><?php echo @$cropscares[0]['consumption']; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><?php echo $Text->getText("form_price"); ?></td>
			<td class="tableRight"><?php echo @$cropscares[0]['price']." Lt"; ?></td>
		</tr>
		<tr>
		    <td class="tableLeft"><button type="button" class="buttonChange" data-cropscares=<?php echo '"'. @$_GET['id']. '"'; ?>><?php echo $Text->getText("form_edit"); ?></button></td>
			<td class="tableRight"><button id="cancel"><?php echo $Text->getText("form_back"); ?></button></td>
		</tr>
	</table>
</div>

<div id="chemicalsReturn">
		<!-- Javascript inserts updated values of chemicals use from doneFields.php -->
</div>

<div>
	<h2><?php echo $Text->getText("works_add_fields"); ?></h2>
	<table>
		<tr>
		    <td class="tableLeft" title="<?php echo $Text->getText("works_title_enable_add"); ?>"><?php echo $Text->getText("works_enable_add"); ?></td>
			<td class="tableRight"><input type="checkbox" name="enableAdd" id="enableAdd"></td>
		</tr>
		<tr>
		    <td class="tableLeft second" title="<?php echo $Text->getText("works_title_date"); ?>"><?php echo $Text->getText("works_date"); ?></td>
			<td class="tableRight second"><input type="date" name="date" id="date" placeholder="yyyy-mm-dd"></td>
			<input type="hidden" name="cropscareID" value=<?php echo '"'.@$_GET['id'].'"'; ?> id="cropscareID">
		</tr>
	</table>
</div>

<div id="fieldsReturn">
	<!-- Javascript inserts updated values of fields use from doneFields.php -->
</div>

<script type="text/javascript">
	function updateFieldsReturn(){
		$.get('pages/cropscares/views/doneFields.php'+<?php echo "'?id=".@$_GET['id']."&consumption=".@$cropscares[0]['consumption']."'"; ?>, function(data){
	        data = JSON.parse(data);
	        $('#area').html(data.area);
	        $('#fieldsReturn').html(data.fieldsReturn);
	        $('#chemicalsReturn').html(data.chemicalsReturn);
	        $('.show').bind("click", showField);
      	});
	    return false;
	};

	updateFieldsReturn();

    function showField() {
    	// alert("aa");
	    var file = "pages/fields/views/showField.php?back=showcropscare&bid="+<?php echo @$_GET['id']; ?>+"&id=";
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
	    var file = "pages/cropscares/views/editCropscare.php?id="
		file += $(this).data('cropscares');
	    
	    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
	    
	    $.get(file, function(data){
	        $('#content').html(data);
	      });
	    return false;
	});


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
	        	echo 'var file = "pages/cropscares/index.php";';
	        	echo '$(\'#content\').html("<center><img src=\'img/ajax-loader.gif\' style=\'padding-top: 50px;\'></center>");';
	        	echo '$.get(file, function(data){$(\'#content\').html(data);});';
	     	}
	    ?>
        

        return false;
    });

</script>