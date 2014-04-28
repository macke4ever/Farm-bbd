<?php 
	session_start();
	include "../../dbConfig.php";

	$user = $db->query("SELECT `users`.firstname as firstname, `users`.lastname as lastname, `users`.id as id, `farms`.name as farm, `farms`.adress as adress FROM users LEFT JOIN farms ON `users`.farm_id = `farms`.id WHERE `users`.id = ".$_SESSION['user_id'].";");
	$user = $user[0];
	// var_dump($user);
 ?>

<h2>Vartotojo informacija</h2>
<form id="changeUserInfo" action="pages/users/actions/changeUserInfo.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Vardas</td>
			<td class="tableRight"><?php echo $user["firstname"]; ?></td>
		</tr>
		<tr>
			<td class="tableLeft second">Pavardė</td>
			<td class="tableRight second"><?php echo $user["lastname"]; ?></td>
		</tr>
		<tr>
			<td class="tableLeft">Ūkis</td>
			<td class="tableRight"><input type="text" name="farm" id="farm" value=<?php echo "\"".$user["farm"]."\""; ?> style="width: 261px;" tabindex="1"></td>
		</tr>
		<tr>
			<td class="tableLeft second">Ūkio adr.</td>
			<td class="tableRight second"><input type="text" name="adress" id="adress" value=<?php echo "\"".$user["adress"]."\""; ?> style="width: 261px;" tabindex="2"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Saugoti" tabindex="3"/></td>
			<td class="tableRight"></td>
		</tr>
	</table>
</form>

<h2>Slaptažodžio keitimas</h2>
<div id="message" style="color: red; padding: 0 10px; font-size: 14px;"></div>
<form id="changeUserPass" action="pages/users/actions/changeUserPass.php" method="post">
	<table>
		<tr>
			<td class="tableLeft">Senas Pass.</td>
			<td class="tableRight"><input type="password" name="oldpass" id="oldpass" style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft second">Naujas Pass.</td>
			<td class="tableRight second"><input type="password" name="newpass1" id="newpass1" style="width: 261px;"></td>
		</tr>
		<tr>
			<td class="tableLeft">Pakartokite</td>
			<td class="tableRight"><input type="password" name="newpass2" id="newpass2" style="width: 261px;"></td>
		</tr>
		<tr>
		    <td class="tableLeft"><input type="submit" id="submit" name="submit" value="Keisti" tabindex="3"/></td>
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
			$('#message').html("Visi laukeliai turi būti užpildyti"); 
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
    		$('#message').html("Nesutampa slaptažodžiai"); 
	     	$('#newpass1').val("");	
	     	$('#newpass2').val("");	
    		return false;
    	}
    return false;
    });
</script>