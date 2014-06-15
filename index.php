<?php 
  if(session_id() == '') {
      session_start();
  }

  include_once "class.text.php";
 ?>
<html>
<head>
  <title>AgroServ - Žemės ūkio vladymo sistema</title>
  <meta charset='utf-8'> 


<?php 
  // baziniai reikalai reikalingi prisijungimams ir darbui su sesija

  $message = "";

  if (!empty($_GET['message'])) {
    $message = $_GET['message'];
  }

  // login sekcijos pradzia
  if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])){
      include "loginForm.php";
  // login sekcijos pabaiga
  } else {

 ?>

  <!-- Using locally stored libs -->
  <script src="libs/jquery.min.js"></script>
  <script src="libs/jquery.form.js"></script>
  <!-- Using same libs but from external sources -->
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
  <!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->

  <!-- second two lines enables map -->
  <script src="addMaps.php"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7sW8qEiGV-7ji0mwjwASjxh66OZKZJMk&sensor=true"></script>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="chosen/chosen.css">
</head>
<body>
  <div id="map"></div>
  <div id="settings" class="cf">
    <div id="main">
      <?php include_once "main.php"; ?>
    </div>
  </div>
</body>

<?php include "enableMaps.php"; ?>

<script type="text/javascript"> 
  //vis dar neaisku kokio velnio as sita reikala rasiau.
  //greiciausiai kad zymeti darbas atliktas ar ne.
  $('#save').click(function(){

  darbas = $('#darbas').val();
  darbas = 'kulti';
      a = $.extend({}, pazymeti);
      duom = {};
      duom.laukai = a;
      duom.darbas = darbas;
      console.log(a);
      $.post('saugoti.php', duom).done(function(data){
        console.log(data);
      });
      alert('pavyko');

      $('#save').html('issaugoti');
    });
</script>

<?php  } ?>

</html>