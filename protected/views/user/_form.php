<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldBlock($model,'username',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->passwordFieldBlock($model,'password',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldBlock($model,'salt',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldBlock($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textAreaBlock($model,'profile',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldBlock($model,'school_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldBlock($model,'firstName',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldBlock($model,'lastName',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldBlock($model,'gender',array('class'=>'span5')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
