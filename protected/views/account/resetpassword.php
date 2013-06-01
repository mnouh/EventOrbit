<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'resetpassword-form',
	'enableAjaxValidation'=>true,
        //'focus' => array($model,'username'),
        'clientOptions'=>array('validateOnSubmit'=>TRUE, 'validationDelay' => 100),
)); ?>
<div id="main-content" class="clearfix">
<div class="form" id="customForm" class="sync">
    <div id="content-container">
        <h2>Forgot your password?</h2>
      <h3>
        &nbsp;
      </h3>
      <p class="description">You must supply your school email address (ex: me@binghamton.edu).</p>
      <p>
          Before we can send you instructions about resetting your password. We need you to identify your account, please enter a valid email address, and we will send you instructions on how to reset your password.
      </p>
      <div id="forgotpassword">
            <div>
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username', array ('class' => 'sync')); ?>
                <?php echo $form->error($model,'username'); ?>
		
	</div>
          
      
      
      
      <div id="load">
      <?php //echo CHtml::submitButton('Verify Account', array('name' => 'Submit', 'class' => 'btn primary'));  
                        
              
                        echo CHtml::ajaxSubmitButton(
                                        'Send Instructions',
                                        array(''),
                                        array('success'=>'js:function(data) {
                                                    jQuery("div#status").html(data);
                                                    jQuery("div#load").removeClass("loading");      
                                               }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load").addClass("loading");}',
                                                //'validated' => 'function() {changeButton();}',
                                                //'complete' => 'function() {changeButton();}',
                                                'type' => 'POST'
                                        ),
                                array('class'=> 'btn primary')
                                );
      
      ?>
                         
      </div>
          
      </div>
      <div id="status"></div>
</div>
</div>
</div>
<?php $this->endWidget(); ?>