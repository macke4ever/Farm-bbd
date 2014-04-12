<div id="uploadCoordinates">
	<form id="myForm" class="upload" action="upload/step1.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file" id="file" placeholer="Pasirinkite failą">
		<input type="submit" name="submit" value="OK" style="float: right; margin-right: 7px;">
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
        
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#myForm").ajaxForm(options);
 
});
 

</script>