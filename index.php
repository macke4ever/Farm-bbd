<html>
<head>
  <title>AgroServ - Žemės ūkio vladymo sistema</title>
  <meta charset='utf-8'> 


<?php 
  // baziniai reikalai reikalingi prisijungimams ir darbui su sesija
  session_start();

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
    <ul class='menu cf'>
      <li data-menu='pages/fields/index.php'><a href="">Laukai</a></li>     
      <li data-menu='pages/cropscares/index.php'><a href="">Priežiūra</a></li>       
      <li data-menu='pages/fieldworks/index.php'><a href="">Dirbimai</a></li>        
      <!-- <li data-menu='pages/seedings/index.php'><a href="">Sėja</a></li>   -->
      <li data-menu='pages/seeds/index.php'><a href="">Sėklos</a></li>   
      <li data-menu='pages/chemicals/index.php'><a href="">Chemija</a></li>  
      <li data-menu='pages/settings.php'><a href=""><img src="img/settings.png"></a></li>
    </ul>   
    
    <div id='content'>
    </div>
    <div id='content2'>
    </div>

    <!-- <div id='mapCoordsInclude'></div> -->
    <!-- <div id='mapCoordsInclude'><?php  //include "addMaps.php"; ?></div> -->


  </div>
</body>

<?php include "enableMaps.php"; ?>


<script type="text/javascript">
//Menu conroller

  
  //nustatomas pirmo puslapio vaizdas - i kairi stulpeli ikalamas fields.php sugeneruotas kodas.
  $.get("pages/fields/index.php", function(data){$('#content').html(data);});

  //nustatomas puslapio vaizdas - i kairi stulpeli ikalamas paspausto tabo sugeneruotas kodas.
  $('.menu li').click(function(){
    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
    
    var file = $(this).data('menu');
    $.get(file, function(data){
        $('#content').html(data);
      });
    resetMaps();
    return false;
  });
</script>


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


<script type="text/javascript">

  //puslapio vaizdo sutvarkymas ir resizinimas pagal lango dydi.

  function mapSize(){
    var pl = $('body').width();
    mpl = pl - $('#settings').width();
    $('#map').width(mpl);
  }

  function contentSize(){
    var pl = $('#settings').height();
    mpl = pl - 30;
    //mpl = pl - $('.menu').height();
    $('#content').height(mpl);
  }

  $(window).resize(function(){
    mapSize();
    contentSize();
  });

  $(document).ready(function() {
    mapSize();
    contentSize();
  //   // $.get('mainSettings.php', function(data){
  //   //  $('#content').html(data);
  //   // });
  });
</script>

<?php  } ?>

</html>