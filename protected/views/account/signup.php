<?php
$this->pageTitle=Yii::app()->name . ' - Sign Up';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <?php if(Yii::app()->user->hasFlash('signup')): ?>
    
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('signup'); ?>

</div>
    <?php else: ?>
    
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
        //'focus' => array($model,'firstName'),
	'enableAjaxValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>TRUE, 'validationDelay' => 100),
)); ?>




<section>
<h3>User Registration </h3>
  <div class="signin">
    <div class="floatLeft">First Name  : </div>
    
    <div class="fR">
        <?php echo $form->textField($model,'firstName'); ?>
        <?php echo $form->error($model,'firstName', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>
    <div class="floatLeft">Last Name  : </div>
    <div class="fR">
      <?php echo $form->textField($model,'lastName'); ?>
      <?php echo $form->error($model,'lastName', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>
	<div class="floatLeft">Email Address: </div>
    <div class="fR">
      <?php echo $form->textField($model,'email'); ?>
      <?php echo $form->error($model,'email', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>
	<div class="floatLeft">Password : </div>
    <div class="fR">
      <?php echo $form->passwordField($model,'password'); ?>
      <?php echo $form->error($model,'password', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>
        <div class="floatLeft">Zip Code: </div>
    <div class="fR">
      <?php echo $form->textField($model,'zip_code', array('style' => 'width:75px;')); ?>
      <?php echo $form->error($model,'zip_code', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>
	<div class="floatLeft">Gender : </div>
    <div class="fR">
      <?php echo $form->radioButtonList($model, 'gender', array(0 =>'Male', 1 => 'Female')) ?>
      <?php echo $form->error($model,'gender', array('class'=>'error')); ?>
    </div>
    <div class="clear"></div>

    <div class="fR remember">
      <?php echo $form->checkBox($model, 'terms', array('uncheckValue' => '', 'value' => 1));?>
      <label for="remember">I accept terms &amp; conditions </label>
      <?php echo $form->error($model, 'terms', array('errorCssClass' => 'errorMessage'));?>
    </div>
    <div class="clear"></div>
	<div class="fR">
      <input name="Submit" type="submit" class="submitButton" value="Sign Up">
    </div>
    <div class="clear"></div>
  </div>
</section>








    

    

<!-- form -->
<?php $this->endWidget(); ?>
                
<?php endif; ?>