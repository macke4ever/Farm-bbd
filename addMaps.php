  //lauku valymo funkcija
function clearMap () {
    while(laukai[0])
    {
      laukai.pop().setMap(null);
    }
}

function addMaps(){
 
  //isvalomi visi egzisuotjantys map'e polygonai. Tai reikalinga kai pridedamos arba pasalinamos lauko koordinates. Atnaujinamas visas mapas - perpiesiami polygonai 
  clearMap();
  
  <?php

   include "dbConfig.php";
    $r = mysql_query("SELECT `fields`.id as id,  `fields`.coordinates as coordinates, `laikina`.culture_id as culture_id, `cultures`.color as color, `harvestings`.date as harvest FROM `fields` LEFT OUTER JOIN (SELECT * FROM seedings where season_id = ".$_SESSION['user_season'].") as laikina ON `laikina`.field_id = `fields`.id LEFT OUTER JOIN cultures ON `laikina`.culture_id = `cultures`.id LEFT OUTER JOIN harvestings ON `fields`.id = `harvestings`.field_id where `fields`.farm_id = '".$_SESSION['user_farm']."'");
    // echo "SELECT `fields`.id as id,  `fields`.coordinates as coordinates, `seedings`.culture_id as culture_id, `cultures`.color as color FROM `fields` INNER JOIN seedings ON `seedings`.field_id = `fields`.id INNER JOIN cultures ON `seedings`.culture_id = `cultures`.id where `fields`.farm_id = '4'";
    // $r = mysql_query("SELECT id, coordinates from fields where coordinates != '' and farm_id = ".$_SESSION["user_farm"]."'");   
 

    //gaunakmos koordinates is Duombazes ir sukalamos i masyva.
    $fields = array();
    while($field = mysql_fetch_assoc($r)){
        $fields[$field['id']] = $field;  
    $cord = explode(';', $field['coordinates']);
    unset($cord[count($cord)-1]);

    echo "var laukas".$field['id'].";\n";


    //sutveriamos lauko koordinates is gautu is MySQL duombazes
    echo 'var polygonCoords = [';
          foreach ($cord as $key => $c) {
            if($key == count($cord)-1)
              echo "new google.maps.LatLng(".$c.")";
            else
              echo "new google.maps.LatLng(".$c."),";
          }
          echo "];\n";
          // echo "laukas".$field['id']." = new google.maps.Polygon({ paths: polygonCoords, strokeColor: '#000000', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#000000', fillOpacity: 0.35, id: ".$field['id']." }); laukai.push(laukas".$field['id'].");\n";}
          $color = "#000000";
          if (!empty($field['culture_id']) && !empty($field['color'])){
            $color = $field['color'];
          }
          $color2 = $color;
          if (!empty($field['harvest']) && ($field['harvest']) != "0000-00-00"){
            $color2 = "#FFFFFF";
          }
          echo "laukas".$field['id']." = new google.maps.Polygon({ paths: polygonCoords, strokeColor: '".$color."', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '".$color2."', fillOpacity: 0.35, id: ".$field['id']." }); laukai.push(laukas".$field['id'].");\n";}

    echo"\n";
      foreach($fields as $key => $field)
      {
        //nustatomas mapas konkretaus lauko koordinatems, plius pridedamas listeneris kuris vykdo funkcija showFieldInfo. Ant jos reikai kabinti visus veiksmus per Case
        //arba IF sakinius, pagal atitinkamus pasirinktus tabus.
      echo "  laukas". $field['id'].".setMap(map); google.maps.event.addListener(laukas".$field['id'].", 'click', showFieldInfo);\n";
      }
    ?>
}


function resetMaps(){
  $.each(laukai, function(index){
            laukai[index].setOptions({fillOpacity :0.35});
        });
}

//info apie lauka arba veiksmai su lauku, cia tveriami visi case pagal paspausta taba
function showFieldInfo(event) {

  testSession();

  if (document.getElementById('fieldwork-view') != null) {
    enableAdd = $('#enableAdd').prop('checked');
    date = $('#date').val();
    fieldworkID = $('#fieldworkID').val();

    if (enableAdd) {
      var posting = $.post( 'pages/fields/actions/addWorkToField.php', { date: date, field_id: this.id, id: fieldworkID, workType: 'fieldWork' } );
       posting.done(function( data ) {
        updateFieldsReturn();
        var file2 = "markWorkFields.php?workType=fieldwork&workID="+fieldworkID;
        $.get(file2, function(data){ $('#content2').html(data); });
      });
    }
    return 0;
  }

  if (document.getElementById('cropscare-view') != null) {
    enableAdd = $('#enableAdd').prop('checked');
    date = $('#date').val();
    cropscareID = $('#cropscareID').val();

    if (enableAdd) {
      var posting = $.post( 'pages/fields/actions/addWorkToField.php', { date: date, field_id: this.id, id: cropscareID, workType: 'cropscare' } );
       posting.done(function( data ) {
        updateFieldsReturn();
        var file2 = "markWorkFields.php?workType=cropscare&workID="+cropscareID;
        $.get(file2, function(data){ $('#content2').html(data); });
      });
    }
    return 0;
  }

    var page = "pages/fields/views/showField.php?id=";
    page += this.id;
    $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
    $.get(page, function(data){
      $('#content').html(data);
    });  
    resetMaps();        
    paryskinti(this);
}
