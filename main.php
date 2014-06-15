<?php 
  session_start();

  include_once "class.text.php";

?>
    <ul class='menu cf'>
      <li data-menu='pages/fields/index.php'><a href=""><?php echo $Text->getText("menu_fields"); ?></a></li>     
      <li data-menu='pages/cropscares/index.php'><a href=""><?php echo $Text->getText("menu_cropscares"); ?></a></li>       
      <li data-menu='pages/fieldworks/index.php'><a href=""><?php echo $Text->getText("menu_fieldworks"); ?></a></li>        
      <li data-menu='pages/seeds/index.php'><a href=""><?php echo $Text->getText("menu_seeds"); ?></a>
      <li data-menu='pages/chemicals/index.php'><a href=""><?php echo $Text->getText("menu_chemicals"); ?></a></li>  
      <li data-menu='skip'><a href=""><img src="img/settings.png"></a>
        <ul>
            <li data-menu='pages/users/user.php'><a href=""><b><?php echo $_SESSION["firstname"]." ".$_SESSION["lastname"]; ?></b></a></li>
            <li data-menu='guide'><a href=""><?php echo $Text->getText("menu_userguide"); ?></a></li>
            <li data-menu='logout'><a href="logout.php"><?php echo $Text->getText("menu_disconnect"); ?></a></li>
        </ul>
      </li>
    </ul>   
    
    <div id='content'></div>
    <div id='content2'></div>


<script type="text/javascript">
  function testSession(){
      $.get('session.php', function(data) {
       if( data == "Expired" ) {
           // alert("Session expired");
           window.location.href = "logout.php";
       }
   });
  }


  testSession();
//Menu conroller

  
  //nustatomas pirmo puslapio vaizdas - i kairi stulpeli ikalamas fields.php sugeneruotas kodas.
  <?php if (!empty($_GET["page"]) && $_GET["page"] == "user") {?> 
      $.get("pages/users/user.php", function(data){$('#content').html(data);});
  <?php } else { ?>
    $.get("pages/fields/index.php", function(data){$('#content').html(data);});
  <?php } ?>

  //nustatomas puslapio vaizdas - i kairi stulpeli ikalamas paspausto tabo sugeneruotas kodas.
  $('.menu li').click(function(){
      testSession();

      // logout
      if ($(this).data('menu') == "logout"){
        window.location.href = "logout.php";
        return false;
      }

      // user guide
      if ($(this).data('menu') == "guide"){
        var win=window.open("UserGuide_ZUVS.pdf", '_blank');
        win.focus();
        return false;
      }

      // other menu buttons
      // skip is used to disable link clickability
      if ($(this).data('menu') !== "skip"){
      var file = $(this).data('menu');
        $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
        $.get(file, function(data){
            $('#content').html(data);
          });
        resetMaps();
      }
      return false;
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

  mapSize();
  contentSize();

</script>