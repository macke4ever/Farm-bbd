<html>
<head>
	<title>AgroServ - Žemės ūkio vladymo sistema</title>
  <meta charset='utf-8'> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7sW8qEiGV-7ji0mwjwASjxh66OZKZJMk&sensor=true"></script>
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="map"></div>
  <div id="settings">
    <ul class='menu'>
      <li data-menu='pages/fields.php'><a href="">Laukai</a></li>     
      <li data-menu='pages/cropscares.php'><a href="">Priežiūra</a></li>       
      <li data-menu='pages/fieldWorks.php'><a href="">Dirbimai</a></li>        
      <li data-menu='pages/seedings.php'><a href="">Sėja</a></li>  
      <li data-menu='pages/seeds.php'><a href="">Sėklos</a></li>   
      <li data-menu='pages/chemicals.php'><a href="">Chemija</a></li>  
      <li data-menu='pages/settings.php'><a href=""><img src="img/settings.png"></a></li>
    </ul>   
    
    <div id='content'>
    </div>

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


function addMaps(){

  <?php

   include "../connection/dbConfig.php";
   //$r = mysql_query("select * from fields where coordinates !='' and farm_id = 4" ); 
    $r = mysql_query("SELECT `fields`.id as id,  `fields`.coordinates as coordinates, `seedings`.culture_id as culture_id, `cultures`.color as color FROM `fields` INNER JOIN seedings ON `seedings`.field_id = `fields`.id INNER JOIN cultures ON `seedings`.culture_id = `cultures`.id where `fields`.farm_id = '4'" );   
 

    $fields = array();
    while($field = mysql_fetch_assoc($r)){
        $fields[$field['id']] = $field;
    $cord = explode(';', $field['coordinates']);
    unset($cord[count($cord)-1]);


    echo "var laukas".$field['id'].";\n";


    echo 'var polygonCoords = [';

          foreach ($cord as $key => $c) {
            if($key == count($cord)-1)
              echo "new google.maps.LatLng(".$c.")";
            else
              echo "new google.maps.LatLng(".$c."),";
          }

          echo "];\n";
          echo "laukas".$field['id']." = new google.maps.Polygon({
      paths: polygonCoords, strokeColor: '".$field["color"]."', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '".$field["color"]."', fillOpacity: 0.35, id: ".$field['id']." }); laukai.push(laukas".$field['id'].");\n";
        }
        ?>

    <?php
    echo"\n";
      foreach($fields as $key => $field)
      {
      echo "  laukas". $field['id'].".setMap(map); google.maps.event.addListener(laukas".$field['id'].", 'click', showFieldInfo);\n";
      }
    ?>
}


function showFieldInfo(event) {
  if (document.getElementById('fields') != null) {
          //alert(this.id);
          var page = "pages/showField.php?id=";
          page += this.id;
          $.get(page, function(data){
            $('#content').html(data);
          });
        }
}

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

  $( document ).ready(function() {
    mapSize();
    contentSize();
    // $.get('mainSettings.php', function(data){
    //  $('#content').html(data);
    // });
  });


  $.get("pages/fields.php", function(data){$('#content').html(data);});

  $('.menu li').click(function(){
    var file = $(this).data('menu');
    $.get(file, function(data){
        $('#content').html(data);
      });
    return false;
  });

</script>

</html>