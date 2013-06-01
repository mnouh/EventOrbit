<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
	'enableAjaxValidation'=>true,
        //'focus' => array($model,'username'),
        'clientOptions'=>array('validateOnSubmit'=>TRUE),
)); ?>
<div id="main-content" class="clearfix">
<div class="form" id="customForm" class="sync">
<div id="admin-request-container">
    <h2>Login</h2>
      
    <h3><p class="description"><span class="disclaimer">* Not available for all schools</span>Please login with your school email address.*</p></h3>
    
    
            <div>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username', array ('class' => 'sync')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array ('class' => 'sync')); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>

	<div>
		<?php echo $form->checkBox($model,'rememberMe'); ?> Remember me
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>
    
                <div>
                    <a id ="haveCode" style="width: 75px;" class="btn lock">Login</a>
                </div>
    <div>       
    <p class="description" style="float:right;"> 
            <?php echo CHtml::link('Forgot your password ?', array('account/reset')); ?><span>&nbsp;or&nbsp;</span>
            <?php echo CHtml::link('Activate your account', array('account/verify')); ?>
          </p>
    </div>
                    
                
      
        
        <div id="space"></div>
        
        
      
   
    
<?php $this->endWidget(); ?>
        </div>
    </div>
</div>