<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
        
        
        <link rel="shortcut icon" type="image/x-icon" href="http://notesforus.com/images/favicon.ico" />
        <link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/anylinkcssmenu.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" />

	<!-- blueprint CSS framework -->
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
        <link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
        
</head>
 
  
<script type="text/javascript">
  
//anylinkcssmenu.init("menu_anchors_class") ////Pass in the CSS class of anchor links (that contain a sub menu)
anylinkcssmenu.init("anchorclass")
</script>
    
  
<body>
<div id="Content">
<div class="search">
<div class="holder">
<div class="floatLeft">
  <input name="textfield" type="text" class="inputBox" value="Search" />
  <input type="image" name="imageField" src="<?php echo Yii::app()->request->baseUrl; ?>/images/btn.gif" />
</div>
<div class="fL">
  <ul>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/home/">Home         </a></li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/me/">Profile         </a></li>
    <li><a href="#">Inbox         </a></li>
    <li><a href="mycourses.php">Courses</a></li>
    <li><a href="myschool.php">School</a></li>
    <li><a href="#">Resources</a></li>
  </ul>
  </div>
<div class="floatRight"><a href="#" class="anchorclass menu" rel="submenu1">Account</a><a href="#" class="notification"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/notification.png" alt="" width="27" height="23" border="0" /></a></div>
<div id="submenu1" class="anylinkcss">
<ul>
<li><a href="<?php echo Yii::app()->request->baseUrl; ?>/me/settings">Settings</a></li>
<li><a href="#">Help</a></li>
<li><?php echo CHtml::link('Logout',array('account/logout')); ?></li>
</ul>
</div>
</div>
</div>
<div class="top">
<div class="holder">
<div class="floatLeft">Welcome <?php echo CHtml::encode(Yii::app()->user->name); ?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span>Binghamton University</span></div>
<div class="floatRight"><?php echo CHtml::link('Logout',array('account/logout')); ?></div>
<div class="clear"></div>
</div>
</div>
<div class="btm">
<div class="holder">
    <div class="floatLeft">
  <ul>
    <li><a href="#" class="recent sel">Profile Options</a></li>
    <li><a href="#" class="books">Personal Information</a></li>
    <li><a href="#" class="courses"> Courses</a></li>
    <li><a href="#" class="calender"> Calendar</a></li>
    <li><a href="#" class="people">Change Password</a></li>
    <li><a href="#" class="groups"> Groups</a></li>
  </ul>
</div>
     

  <!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
	<?php echo $content; ?>
        
<div class="clear"></div>
</div>
</div>
</div>
<div id="Footer">
<div class="holder" style="width:60%;">
<div class="floatLeft">
  <p class="bigTxt"><a href="#">About</a>    &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;     <a href="#">Blog</a>     &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;     <a href="#">Contact</a>     &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;     <a href="#">Jobs</a>     &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;     <a href="#">Privacy</a></p>
  <p>Copyright &copy; 2011, Notes for us. All Rights Reserved.</p>
  <p><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="" width="32" height="32" border="0" /></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook.png" alt="" width="32" height="32" border="0" /></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/in.png" alt="" width="32" height="32" border="0" /></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/gplus.png" alt="" width="50" height="32" border="0" /></a></p>
</div>
<div class="floatRight"></div>
<div class="clear"></div>
</div>
</div>
</body>
</html>