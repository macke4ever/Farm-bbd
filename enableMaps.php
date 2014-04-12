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
  } 
  // else {
    // obj.setOptions({fillOpacity :0.35});
  // }
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