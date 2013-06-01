$(document).ready(function() 
{

$("#update_discussion").click(function() 
{
var updateval = $("#comments").val();

//var uploadvalues=$("#uploadvalues").val();

var z = 1;
var dataString = 'message='+ updateval+'&id='+z;
if($.trim(updateval).length==0)
{
alert("Please Enter Some Text");
}
else
{
//$("#flash").show();
//$("#flash").fadeIn(400).html('Loading Update...');
$.ajax({
type: "POST",
url: "http://localhost/~mnouh/vout/discuss",
data: dataString,
cache: false,
success: function(html)
{
    /*
$("#webcam_container").slideUp('fast');
$("#flash").fadeOut('slow');
$("#content").prepend(html);
$("#update").val('');	
$("#update").focus();
$('#preview').html('');
$('#webcam_preview').html('');
$('#uploadvalues').val('');
$('#photoimg').val('');
$("#stexpand").oembed(updateval);
*/
$("div#reviewDiscussion").prepend(html);
  }
 });
 //$("#preview").html();
//$('#imageupload').slideUp('fast');
}
return false;
	});
});