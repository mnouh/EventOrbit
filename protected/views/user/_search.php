<?php $form=$this->beginWidget('CActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textField($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textField($model,'username',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textField($model,'salt',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textField($model,'email',array('class'=>'span5','maxlength'=>128)); ?>


	<?php echo $form->textField($model,'firstName',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textField($model,'lastName',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textField($model,'gender',array('class'=>'span5')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
