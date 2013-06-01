<div class="view">

	<b><?php echo BootHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo BootHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo BootHtml::encode($data->username); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo BootHtml::encode($data->password); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
	<?php echo BootHtml::encode($data->salt); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo BootHtml::encode($data->email); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('profile')); ?>:</b>
	<?php echo BootHtml::encode($data->profile); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('school_id')); ?>:</b>
	<?php echo BootHtml::encode($data->school_id); ?>
	<br />

	<?php /*
	<b><?php echo BootHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo BootHtml::encode($data->firstName); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('lastName')); ?>:</b>
	<?php echo BootHtml::encode($data->lastName); ?>
	<br />

	<b><?php echo BootHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo BootHtml::encode($data->gender); ?>
	<br />

	*/ ?>

</div>