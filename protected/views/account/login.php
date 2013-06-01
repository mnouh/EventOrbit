<?php
$this->pageTitle=Yii::app()->name . ' - Login';
//$this->breadcrumbs=array(
//	'Login',
//);
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/helpers.js', CClientScript::POS_HEAD);  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.bar.custom.js', CClientScript::POS_HEAD);

if(isset($_GET['status'])) {
if($_GET['status'] == 'error') {
   ?> 
   <body onload="showWarning('Incorrect Login Information.');">
<?php
    }
}

?>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
	'enableAjaxValidation'=>true,
        //'focus' => array($model,'username'),
        'clientOptions'=>array('validateOnSubmit'=>TRUE),
)); ?>
       
       
<section>
  <h3>User Login</h3>
  <div class="login">
<div class="floatLeft">Username : </div>
<div class="fR">
  <?php echo $form->textField($model,'username'); ?>
  <?php echo $form->error($model,'username', array('class'=>'error')); ?>
</div>
<div class="clear"></div>
<div class="floatLeft">Password : </div>
<div class="fR">
  <?php echo $form->passwordField($model,'password'); ?>
  <?php echo $form->error($model,'password', array('class'=>'error')); ?>
</div>
<div class="clear"></div>
<div class="fR">

				                  <?php echo CHtml::submitButton('Login', array('name' => 'Submit', 'class' => 'submitButton')); ?>
</div>
<div class="clear"></div>
<div class="fR remember"> 
  <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
  <label for="remember">Remember me</label>
&nbsp;&nbsp;|&nbsp;&nbsp;<strong><?php echo CHtml::link('Forgot your password ?', array('account/resetpassword/')); ?></strong> </div>
<div class="clear"></div>
</div>
</section>
    
<?php $this->endWidget(); ?>
        