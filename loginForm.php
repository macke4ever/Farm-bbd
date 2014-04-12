<link rel="stylesheet" href="styleLogin.css">
</head> 
 <body>
    <form name="LoginForm" method="post" action="login.php">
    <div class="message"><?php if($message!="") { echo $message; } ?></div>
    <table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
      <tr class="tableheader">
        <td align="center" colspan="2">Įveskite prisijungimo duomenis</td>
      </tr>
      <tr class="tablerow">
        <td align="right">Username</td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr class="tablerow">
        <td align="right">Password</td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr class="tableheader">
        <td align="center" colspan="2"><input type="submit" name="submit" value="Prisijungti"></td>
      </tr>
    </table>
  </form>
 </body>