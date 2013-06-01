<script type="text/javascript">

$(document).ready(function(){

$("a.btn#editProfile").click(function(){
    $("div#profile").addClass('wellSelect');
    $("a.btn#editProfile").hide();
    $("a.btn#doneEdit").removeClass('invisible');
    $("a.btn#doneEdit").show();
    //$("a.btn#doneEdit").show();
    
    //$("input#VerifyForm_username").focus();
    
  });
  
  
  $("a.btn#doneEdit").click(function(){
    $("div#profile").removeClass('wellSelect');
    $("a.btn#doneEdit").hide();
    $("a.btn#doneEdit").addClass('invisible');
    $("a.btn#editProfile").show();
    //$("a.btn#editProfile").removeClass('invisible');
    //$("a.btn#editProfile").show();
    //$("input#VerifyForm_username").focus();
    
  });


}
);
</script>
<h2><?php echo $data->firstName; ?></h2>
<a id ="editProfile" class="btn primary">Edit Profile</a>
<a id ="doneEdit" class="btn success invisible">Done Edit</a>


<div class="wellWall">
<div class="view">
    
<div id ="profile">    
	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />
</div>
	<div id="profile">

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />
        </div>
    <div id="profile">
	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_image')); ?>:</b>
	<?php echo CHtml::encode($data->profile_image); ?>
	<br />
    </div>
    
    <div id="profile">
	<b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo CHtml::encode($data->firstName); ?>
	<br />
    </div>

    <div id="profile">
	<b><?php echo CHtml::encode($data->getAttributeLabel('school_name')); ?>:</b>
	<?php echo CHtml::encode($data->school_name); ?>
	<br />
    </div>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo CHtml::encode($data->firstName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastName')); ?>:</b>
	<?php echo CHtml::encode($data->lastName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('school_name')); ?>:</b>
	<?php echo CHtml::encode($data->school_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verify_code')); ?>:</b>
	<?php echo CHtml::encode($data->verify_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verified')); ?>:</b>
	<?php echo CHtml::encode($data->verified); ?>
	<br />

	*/ ?>

</div>
</div>