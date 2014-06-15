
<link rel="stylesheet" href="styleLogin.css">
</head> 
<?php 
  include_once "class.text.php";
?>

 <body>
    <form name="LoginForm" method="post" action="login.php">
    <div class="message"><?php if($message!="") { echo $message; } ?></div>
    <table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
      <tr class="tableheader">
        <td align="center" colspan="2"><?php echo $Text->getText("login_define_your_info"); ?></td>
      </tr>
      <tr class="tablerow">
        <td align="right"><?php echo $Text->getText("login_username"); ?></td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr class="tablerow">
        <td align="right"><?php echo $Text->getText("login_password"); ?></td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr class="tableheader">
        <td align="center" colspan="2"><input type="submit" name="submit" value=<?php echo "\"".$Text->getText("login_submit")."\""; ?>></td>
      </tr>
    </table>
  </form>
 </body>