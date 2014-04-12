<html>
<head>
	<title>AgroServ - Žemės ūkio vladymo sistema</title>
  <meta charset='utf-8'> 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
	<script src="libs/jquery.min.js"></script>
  <script src="addMaps.php"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7sW8qEiGV-7ji0mwjwASjxh66OZKZJMk&sensor=true"></script>
  <!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->
  <script src="libs/jquery.form.js"></script>
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
    <!-- <div id='mapCoordsInclude'></div> -->
    <!-- <div id='mapCoordsInclude'><?php  //include "addMaps.php"; ?></div> -->


  </div></body>


<script type="text/javascript">

var map;
var infoWindow;

var laukai = new Array();
var pazymeti = new Array();
function initialize() {
  var myLatLng = new google.maps.LatLng(54.699064, 23.012999);
  var mapOptions = {
    zoom: 13,
    center: myLatLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP 
  }
  map = new google.maps.Map(document.getElementById("map"),mapOptions);
};



window.onload = initialize;

google.maps.event.addDomListener(window, 'load', addMaps);

  // Add a listener for the click event
 // google.maps.event.addListener(laukai[0], 'click', setSelected);
 // google.maps.event.addListener(laukai[1], 'click', setSelected);

 // infoWindow = new google.maps.InfoWindow();



// function showFieldInfo(event) {
//   if (document.getElementById('fields') != null) {
//           //alert(this.id);
//           var page = "pages/fields/views/showField.php?id=";
//           page += this.id;
//           $.get(page, function(data){
//             $('#content').html(data);
//           });
//         }
// }

/** @this {google.maps.Polygon} */
function showArrays(event) {
  document.getElementById("text").textContent = "Pasirinkto laiko ID:" + this.id;

  // Since this Polygon only has one path, we can call getPath()
  // to return the MVCArray of LatLngs
  var vertices = this.getPath();

  var contentString = '<b>Laukas nežinomu pavadinimu</b><br>';
  contentString += 'Paspausta vieta: <br>' + event.latLng.lat() + ',' + event.latLng.lng() + '<br>';
  

  // Iterate over the vertices.
  for (var i =0; i < vertices.getLength(); i++) {
    var xy = vertices.getAt(i);
    contentString += '<br>' + 'Coordinate: ' + i + '<br>' + xy.lat() +',' + xy.lng();
  }

  // Replace our Info Window's content and position
  infoWindow.setContent(contentString);
  infoWindow.setPosition(event.latLng);

  infoWindow.open(map);
 
}

  //nustatomas pirmo puslapio vaizdas - i kairi stulpeli ikalamas fields.php sugeneruotas kodas.
  $.get("pages/fields/index.php", function(data){$('#content').html(data);});

  //nustatomas puslapio vaizdas - i kairi stulpeli ikalamas paspausto tabo sugeneruotas kodas.
  $('.menu li').click(function(){
    var file = $(this).data('menu');
    $.get(file, function(data){
        $('#content').html(data);
      });
    return false;
  });

//funkcija kuri pazymi lauka, ji paryskina.
function setSelected(){
  var yra = $.inArray(this.id, pazymeti);

  console.log(this.fillOpacity);
  if (yra > -1){
    pazymeti.splice(yra, 1);
    console.log('isimam');
  }
  else {
    pazymeti.push(this.id);
    console.log('idedam');
  }

  paryskinti(this);
  console.log(pazymeti);

}
 function paryskinti(obj) {
  if (obj.fillOpacity == 0.35) {
    obj.setOptions({fillOpacity :0.8});
  } else {
    obj.setOptions({fillOpacity :0.35});
  }
 }

  function show() {         
         // laukai[0].setVisible(false);
  }


  function reload_js(src) {
          $('script[src="' + src + '"]').remove();
          $('<script>').attr('src', src).appendTo('head');
  }


  //funkcija addMaps() iskelta i faila addMaps.php
  //funkcija showFieldInfo() iskelta i faila addMaps.php
  //funkcija clearMap() iskelta i faila addMaps.php
  function reloadMaps() {
      reload_js("addMaps.php");
      addMaps();
  }
</script>


<script type="text/javascript">
	
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
    // $.get('mainSettings.php', function(data){
    //  $('#content').html(data);
    // });
  });



  // //lauku valymo funkcija
  // function clearMap () {
  //     while(laukai[0])
  //     {
  //       laukai.pop().setMap(null);
  //     }
  // }

  // function showFieldInfo(event) {
  // if (document.getElementById('fields') != null) {
  //         var page = "pages/fields/views/showField.php?id=";
  //         page += this.id;
  //         $.get(page, function(data){
  //           $('#content').html(data);
  //         });
  // } 

  if (document.getElementById('seedingsModify') != null) {
    // console.log(this.id);
    if (this.clicked == true){
      this.setOptions({fillOpacity: 0.35});
      this.clicked = false;
    } else {
      this.setOptions({fillOpacity: 0.8});
      this.clicked = true;
    }
  }

</script>

</html>