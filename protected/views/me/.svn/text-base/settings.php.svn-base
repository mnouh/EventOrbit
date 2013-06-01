<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$this->pageTitle=Yii::app()->name . ' - Settings';
?>
<script type="text/javascript">

        

        $(document).ready(function(){
        
        var url = 'changepassword?rand='+new Date().getTime()
            
		$('a#changepw').click(function(){
                //$('div#profilePassword').removeClass('hover');
                $('div#profilePassword').addClass('sloading');
                $('a#changepw').addClass('invisible');
                //alert('Hello World');
                
                
                $.get(url, {
                        
                    }, function(response) {
                        
                        
                         //$('div.pw').html(response);
                        
                        $('div#profilePw').append($(response).fadeIn('slow'));
                        $('div#profilePassword').removeClass('sloading');
                        $('div#profilePw').removeClass('Select');
                        $('div#profilePassword').addClass('standard');
                        
                    });
                    
                    /*
			
				$.post("posts?value="+a, {
	
				}, function(response){
					
					$('#posting').prepend($(response).fadeIn('slow'));
					$("#watermark").val("What's on your mind?");
				});
                                
*/			
                    
		});
                
                
});

</script>

<div id="profileName" class="profile Select">
Name: <?php echo $user->firstName .' '. $user->lastName;?> <a href="" class="" style="float: right">Edit</a>
</div>

<div id="profilePassword" class="profile">
    <div id="profilePw" class="profile Select"><label for="passwordlastset">
Password: <?php $output = ($user->password_changed==NULL)? "Password never changed." : "last changed on " .$user->password_changed;
echo $output;?></label> <a id="changepw" style="float: right">Edit</a>
    </div>
</div>

