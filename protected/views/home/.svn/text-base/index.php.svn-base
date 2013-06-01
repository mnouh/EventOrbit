<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php
$this->breadcrumbs=array(
	'Home',
);
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.livequery.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.elastic.js', CClientScript::POS_HEAD);  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.watermarkinput.js', CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    
    function checkButton() {
        var a = $("#watermark").val();
        if(a != "What's on your mind?") {
            
            if(a.length > 0) {
                
                
                $('a#shareButton').removeClass('disabled');
                
                
            }
            else {
                
                $('a#shareButton').addClass('disabled');
                
            }
            
        }
        }

	$(document).ready(function(){
            
         
         
	
        $("input#courseSelect").hide();
        $("a#shareButton").hide();
        $('textarea#watermark').focus(function() {
            if(!$("textarea#watermark").hasClass('addheight')) {
            
           $('div#load').addClass('loading'); 
           setTimeout("$('textarea#watermark').removeClass('inputbox')", 300);
           setTimeout("$('textarea#watermark').addClass('addheight')", 400);
           setTimeout("$('input#courseSelect').show()", 450);
           setTimeout("$('a#shareButton').show()", 460);
           setTimeout("$('div#load').removeClass('loading')", 500); 
           
       }
           
        });
        
        
        
        $('a#messageclose').click(function() {
            
           //$('div#load').addClass('loading'); 
           $('textarea#watermark').removeClass('addheight');
           $('textarea#watermark').addClass('inputbox');
           $('input#courseSelect').hide();
           $("a#shareButton").hide();
           //setTimeout("$('div#load').removeClass('loading')", 800); 
           
           
        });
        
		$('a#shareButton').click(function(){
                    
                    if(!$('a#shareButton').hasClass('disabled')) {
                
			var a = $("#watermark").val();
			if(a != "What's on your mind?")
			{
				$.post("posts?value="+a, {
	
				}, function(response){
					
					$('#posting').prepend($(response).fadeIn('slow'));
					$("#watermark").val("What's on your mind?");
				});
                                
                                $('a#shareButton').addClass('disabled');
			}
                    }
		});	
		
		
		$('.commentMark').livequery("focus", function(e){
			
			var parent  = $('.commentMark').parent();
			$(".commentBox").children(".commentMark").css('width','320px');
			$(".commentBox").children("a#SubmitComment").hide();
			$(".commentBox").children(".CommentImg").hide();			
		
			var getID =  parent.attr('id').replace('record-','');			
			$("#commentBox-"+getID).children("a#SubmitComment").show();
			$('.commentMark').css('width','300px');
			$("#commentBox-"+getID).children(".CommentImg").show();			
		});	
		
		//showCommentBox
		$('a.showCommentBox').livequery("click", function(e){
			
			var getpID =  $(this).attr('id').replace('post_id','');	
			
			$("#commentBox-"+getpID).css('display','');
			$("#commentMark-"+getpID).focus();
			$("#commentBox-"+getpID).children("CommentImg").show();			
			$("#commentBox-"+getpID).children("a#SubmitComment").show();		
		});	
		
		//SubmitComment
		$('a.comment').livequery("click", function(e){
			
			var getpID =  $(this).parent().attr('id').replace('commentBox-','');	
			var comment_text = $("#commentMark-"+getpID).val();
			
			if(comment_text != "Write a comment...")
			{
                            //alert('Hello World');
				$.post("add_comment?comment_text="+comment_text+"&post_id="+getpID, {
	
				}, function(response){
					
					$('#CommentPosted'+getpID).append($(response).fadeIn('slow'));
					$("#commentMark-"+getpID).val("Write a comment...");					
				});
			}
			
		});	
		
		//more records show
		$('a.more_records').livequery("click", function(e){
			
			var next =  $('a.more_records').attr('id').replace('more_','');
			
			$.post("posts?show_more_post="+next, {

			}, function(response){
				$('#bottomMoreButton').remove();
				$('#posting').append($(response).fadeIn('slow'));

			});
			
		});	
		
		//deleteComment
		$('a.c_delete').livequery("click", function(e){
			
			if(confirm('Are you sure you want to delete this comment?')==false)

			return false;
	
			e.preventDefault();
			var parent  = $('a.c_delete').parent();
			var c_id =  $(this).attr('id').replace('CID-','');	
			
			$.ajax({

				type: 'get',

				url: 'delete_comment?c_id='+ c_id,

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						parent.remove();

					});

				}

			});
		});	
		
		/// hover show remove button
		$('.friends_area').livequery("mouseenter", function(e){
			$(this).children("a.delete").show();	
		});	
		$('.friends_area').livequery("mouseleave", function(e){
			$('a.delete').hide();	
		});	
		/// hover show remove button
		
		
		$('a.delete').livequery("click", function(e){

		if(confirm('Are you sure you want to delete this post?')==false)

		return false;

		e.preventDefault();

		var parent  = $('a.delete').parent();

		var temp    = parent.attr('id').replace('record-','');

		var main_tr = $('#'+temp).parent();

			$.ajax({

				type: 'get',

				url: 'delete?id='+ parent.attr('id').replace('record-',''),

				data: '',

				beforeSend: function(){

				},

				success: function(){

					parent.fadeOut(200,function(){

						main_tr.remove();

					});

				}

			});

		});

		$('textarea').elastic();

		jQuery(function($){

		   $("#watermark").Watermark("What's on your mind?");
                   $("input#courseSelect").Watermark(" + Choose your courses");
		   $(".commentMark").Watermark("Write a comment...");

		});

		jQuery(function($){

		   $("#watermark").Watermark("watermark","grey");
		   $(".commentMark").Watermark("watermark","grey");

		});	

		function UseData(){

		   $.Watermark.HideAll();

		   //Do Stuff

		   $.Watermark.ShowAll();

		}

	});	

	// ]]>

</script>

<div id="space"></div>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); ?>

                
                <div class="wellWall">
                    <a id="messageclose" class="close" style="">×</a>
                    <div id="load">
		<textarea class="inputbox" style="outline:none; resize:none;" id="watermark" name="watermark" cols="66" onkeyup='checkButton()'></textarea>
                    </div>
                    
                    
                    <div>
                         <?php echo $form->textField($model,'username', array ('id' => 'courseSelect', 'class' => 'inputtext')); ?>
                    </div>
                    
                    <div>
        
            <a id ="shareButton" class="btn success disabled">Share</a>
            </div>
                </div>
        
                
<?php $this->endWidget(); ?>
    
   
    
</div>
<div class="wellWall">
    
     <div id="posting">
        &nbsp;
    </div>
                <?php
		include_once('dbcon.php');
		include_once('posts.php');?>
</div>