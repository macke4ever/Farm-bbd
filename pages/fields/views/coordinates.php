<?php 

    include_once "../../../class.text.php";

 ?>

<div id="uploadCoordinates">
	<form id="myForm" class="upload" action="upload/step1.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file" id="file" value="<?php echo $Text->getText("fields_choose_coordinates"); ?>">
		<input type="submit" name="submit" value="<?php echo $Text->getText("form_save"); ?>" style="float: right; margin-right: 7px;">
		<input type="hidden" name="id" id="id" value=<?php echo @$_GET['id']; ?>>
	</form>

	<div id="progress">
        <div id="bar">&nbsp;</div>
        <div id="percent">0%</div >
	</div>
	<br/>
 
	<div id="message"></div>
</div>



<script>
$(document).ready(function()
{
 
    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
        $("#message").html("<font color='green'>"+response.responseText+"</font>");
        setTimeout(reloadMaps, 500);
        
        setTimeout(function(){

            var area = 0;
            $.each(laukai, function(index){
                if (laukai[index].id == <?php echo @$_GET['id']; ?>){             
                    area = google.maps.geometry.spherical.computeArea(laukai[index].getPath());
                    // return false;
                }
            });

            var posting = $.post( "upload/setArea.php", {area: area, id: <?php echo @$_GET['id']; ?> } );

            $('#content').html("<center><img src='img/ajax-loader.gif' style='padding-top: 50px;'></center>");
            
            <?php echo "var file = \"pages/fields/views/showField.php?id=".@$_GET['id']."\";"; ?>
            
            
            $.get(file, function(data){
                $('#content').html(data);
        });
        }, 1000);

    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#myForm").ajaxForm(options);
 
});
 

</script>