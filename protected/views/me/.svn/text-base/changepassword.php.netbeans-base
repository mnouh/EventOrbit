<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script type="text/javascript">


$(document).ready(function(){
            
                
                $('a#messageclose').click(function(){
                //$('div.form#customForm').hide();
                jQuery("div.form").remove();
                $('div#profilePw').addClass('Select');
                $('a#changepw').removeClass('invisible');
                $('div#profilePassword').removeClass('standard');
                });
                
                /*
                                                    jQuery("div.entry").hide();
                                                    jQuery("div#profilePw").addClass("Select");
                                                    jQuery("a#changepw").removeClass("invisible");
                                                    jQuery("div#profilePassword").removeClass("standard");
                                                    jQuery("div#status").append(data);
                                                    jQuery("div#load1").removeClass("loading");
                 */
                
                
                
                
                
});

</script>
<div class="form" id="customForm" style="margin-bottom: 0px; padding:0px;" class="sync">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=> TRUE,
        'clientOptions'=>array('validateOnSubmit'=>TRUE, 'validationDelay' => 100),
)); ?>    
<div class="well">
    <a id="messageclose" class="close">×</a>
    <div class="entry">
        <div>
		<?php echo $form->label($model,'currentPassword'); ?>
		<?php echo $form->passwordField($model,'currentPassword', array ('class' => 'sync')); ?>
		<?php echo $form->error($model,'currentPassword'); ?>
	</div>
        
    
        <div>
		<?php echo $form->label($model,'newPassword'); ?>
                <?php
		$this->widget('ext.EStrongPassword.EStrongPassword',
                array('form'=>$form, 'model'=>$model, 'attribute'=>'newPassword', 'htmlOptions' => array('class' => 'sync')));
                ?>
                <?php echo $form->error($model,'newPassword'); ?>
                   
	</div>
    
    
        <div>
		<?php echo $form->label($model,'confirmNewPassword'); ?>
		<?php echo $form->passwordField($model,'confirmNewPassword', array ('class' => 'sync')); ?>
		<?php echo $form->error($model,'confirmNewPassword'); ?>
	</div>
    
        <div>
		<div id="load1">
                
                        
                        <?php //echo CHtml::submitButton('Verify Account', array('name' => 'Submit', 'class' => 'btn primary', 'id' => 'verify'));  
                        
                        
                        echo CHtml::ajaxSubmitButton(
                                        'Save',
                                        array(),
                                        array(
                                                //'success'=>'function() {$("div#load1").removeClass("loading"); }',
                                                'success'=>'js:function(data){
                                                    jQuery("div#profilePw").html(data);
                                                    jQuery("div#load1").removeClass("loading");
                                                    
                                                    }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load1").addClass("loading");}',
                                                //'validated' => 'function() {changeButton();}',
                                                //'complete' => 'function() {changeButton();}',
                                                'type' => 'POST'
                                            //changeButton();
                                        ),
                                array('class'=> 'btn primary', 'type' => 'submit')
                                );
                        ?>
                    
                </div>
            
            
            
	</div>
        
    </div>
      
    <div id="status">
            &nbsp;
            </div>
        
</div>
    

<?php $this->endWidget(); ?>
</div>