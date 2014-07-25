<?php 
	session_start();
	include "../../dbConfig.php";
	include "../../class.text.php";

	$user = $db->query("SELECT `users`.firstname as firstname, `users`.lastname as lastname, `users`.id as id, `farms`.name as farm, `farms`.adress as adress FROM users LEFT JOIN farms ON `users`.farm_id = `farms`.id WHERE `users`.id = ".$_SESSION['user_id'].";");
	$user = $user[0];

	$languages = $db->query("SELECT * FROM languages");
	$seasons = $db->query("SELECT * FROM seasons ORDER BY name DESC");
	// var_dump($user);
 ?>

<h2><?php echo $Text->getText("user_userinfo"); ?></h2>
<form id="changeUserInfo" action="pages/users/actions/changeUserInfo.php" method="post">
	<table>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("user_name"); ?></td>
			<td class="tableRight"><?php echo $user["firstname"]; ?></td>
		</tr>
		<tr>
			<td class="tableLeft second"><?php echo $Text->getText("user_lastname"); ?></td>
			<td class="tableRight second"><?php echo $user["lastname"]; ?></td>
		</tr>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("user_farm"); ?></td>
			<td class="tableRight"><input type="text" name="farm" id="farm" value=<?php echo "\"".$user["farm"]."\""; ?> style="width: 261px;" tabindex="1"></td>
		</tr>
		<tr>
			<td class="tableLeft second"><?php echo $Text->getText("user_farm_adress"); ?></td>
			<td class="tableRight second"><input type="text" name="adress" id="adress" value=<?php echo "\"".$user["adress"]."\""; ?> style="width: 261px;" tabindex="2"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value=<?php echo "\"".$Text->getText("form_save")."\""; ?> tabindex="3"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>

<h2><?php echo $Text->getText("user_pass_change"); ?></h2>
<div id="message" style="color: red; padding: 0 10px; font-size: 14px;"></div>
<form id="changeUserPass" action="pages/users/actions/changeUserPass.php" method="post">
	<table>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("user_old_pass"); ?></td>
			<td class="tableRight"><input type="password" name="oldpass" id="oldpass" style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft second"><?php echo $Text->getText("user_new_pass"); ?></td>
			<td class="tableRight second"><input type="password" name="newpass1" id="newpass1" style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("user_pass_repeat"); ?></td>
			<td class="tableRight"><input type="password" name="newpass2" id="newpass2" style="width: 261px;"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value=<?php echo "\"".$Text->getText("form_save")."\""; ?> tabindex="3"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>

<h2><?php echo $Text->getText("user_variables_change"); ?></h2>
<form id="changeUserVars" action="pages/users/actions/changeUserVars.php" method="post">
	<table>
		<tr>
			<td class="tableLeft"><?php echo $Text->getText("user_language"); ?></td>
			<td class="tableRight">
				<select name="language" id="language" data-placeholder="<?php echo $Text->getText("user_select_language"); ?>" style="width:261px;">
	                <?php 
	                    foreach($languages as $key => $language){
	                        if ($language['shortLang'] == $_SESSION["user_language"]) {
	                        	echo '<option value="'.$language['shortLang'].'" selected>'.$Text->getText($language["keyword"]).'</option>';
	                        } else {
	                        	echo '<option value="'.$language['shortLang'].'">'.$Text->getText($language["keyword"]).'</option>';                            	
	                        }
                        }
	                ?>
	              </select>
			</td>
		</tr>
		<tr>
			<td class="tableLeft second"><?php echo $Text->getText("user_season"); ?></td>
			<td class="tableRight second">
				<select name="season" id="season" data-placeholder="<?php echo $Text->getText("user_select_season"); ?>" style="width:261px;">
	                <?php 
	                    foreach($seasons as $key => $season){
	                        if ($season['id'] == $_SESSION["user_season"]) {
	                        	echo '<option value="'.$season['id'].'" selected>'.$season["name"].'</option>';
	                        } else {
	                        	echo '<option value="'.$season['id'].'">'.$season["name"].'</option>';                            	
	                        }
                        }
	                ?>
	              </select>
			</td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value=<?php echo "\"".$Text->getText("form_save")."\""; ?> tabindex="3"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>

<script type="text/javascript">
    $("#changeUserInfo").submit(function(event) {
	      /* stop form from submitting normally */
	      event.preventDefault();
	      /* get some values from elements on the page: */
	     var $form = $( this ),
	         url = $form.attr( 'action' );
	      /* Send the data using post */
	     var posting = $.post( url, { id: $('#id').val(), farm: $('#farm').val(), adress: $('#adress').val() } );
	     
	     $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

	      /* Put the results in a div */
	     posting.done(function( data ) {
	       var file = "pages/users/user.php";
	       $.get(file, function(data){$('#content').html(data);});
	    });
    });


    $("#changeUserPass").submit(function(event) {
		event.preventDefault();

		if ($('#newpass1').val() == "" || $('#newpass2').val() == "" || $('#oldpass').val() == "") {
			$('#message').html(<?php echo "\"".$Text->getText("user_message_missing_fields")."\""; ?>); 
			return false;
		}

    	if ($('#newpass1').val() == $('#newpass2').val()) {
		     var $form = $( this ),
		         url = $form.attr( 'action' );
		      /* Send the data using post */
		     $.post( url, { oldpass: $('#oldpass').val(), newpass: $('#newpass1').val() }, function(responseText, responseStatus){
		     	$('#message').html(responseText);
		     	$('#oldpass').val("");	
		     	$('#newpass1').val("");	
		     	$('#newpass2').val("");	
		     });

    	} else {
    		$('#message').html(<?php echo "\"".$Text->getText("user_message_missmatch_fields")."\""; ?>); 
	     	$('#newpass1').val("");	
	     	$('#newpass2').val("");	
    		return false;
    	}
    return false;
    });

    $("#changeUserVars").submit(function(event) {
	     event.preventDefault();
	     var $form = $( this ),
	         url = $form.attr( 'action' );
	     var posting = $.post( url, { shortLang: $('#language').val(), season: $('#season').val() } );
	     // console.log(posting);
	     $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");

	      /* Put the results in a div */
	     posting.done(function( data ) {
	       $.get("main.php?page=user", function(data){$('#main').html(data);});
	       reloadMaps();
	    });
    });
</script>

<script src="chosen/chosen.jquery.js" type="text/javascript"></script> 
<script type='text/javascript'> 
      $("#language").chosen();
      $("#language").chosen({allow_single_deselect:true});
</script>