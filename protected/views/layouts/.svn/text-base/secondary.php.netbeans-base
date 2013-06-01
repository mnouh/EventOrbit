<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/styles/css.css" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl;?>/images/favicon.ico" />
<?php Yii::app()->clientScript->registerCoreScript('jquery');?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>
<body>
<header>
  <div class="insideInner">
    <h1 class="logoSmall"><a href="<?php echo Yii::app()->baseUrl;?>">Event Orbit</a></h1>
	<?php if (Yii::app()->user->isGuest) {?>
	<div class="loginTop"><?php echo CHtml::link('Login', array('account/login'), array('class'=> 'loginbtn')); ?></div>
        <div class="signupTop"><?php echo CHtml::link('Signup', array('account/signup'), array('class'=> 'loginbtn')); ?></div>
        <?php } else { ?>
        <div class="afterloginTop">Hello <?php echo Yii::app()->user->firstName.' '. Yii::app()->user->lastName; ?>   |   <?php echo CHtml::link('Logout', array('account/logout'));?>  |   <?php echo CHtml::link('Profile', array('account/profile'));?></div><?php } ?>
	
	<div class="searchArea">
	<div class="floatLeft">
	<div class="top"><strong>Near</strong> (Address,  City,   Zip etc)</div>
	<div class="btm">
	  <input name="textfield" type="text" id="addressInput" class="inputBoxG">
	</div>
	</div>
	<div class="floatLeft">
	<div class="top"><strong>Search for</strong> (e.g.  party, dinner etc.)</div>
	<div class="btm">
	  <input name="textfield2" type="text" id="nameInput" class="inputBox">
	</div></div>
	<input name="Submit" type="submit" class="btn" onClick="searchNewLocationFilter()" value="Search">
	<input name="Submit2" type="submit" class="btn last" value="Add Event">
	<div class="clear"></div>
	</div>							  
  </div>
  
</header>
    <!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>
    
<footer>
  <ul class="top">
    <li class="noBorder"><a href="#">About</a></li>
    <li><a href="#">Products</a></li>
    <li><a href="#">Mobile Apps</a></li>
    <li><a href="#">Business Solutions</a></li>
    <li><a href="#">For Developers</a></li>
    <li><a href="#">Resources &amp; Tools</a></li>
    <li><a href="#">Blog</a></li>
    <li><a href="#">Forum</a></li>
    <li><a href="#">Participate</a></li>
     <li><a href="#">Contact</a></li>
     <li><a href="#">Connect</a> </li>
  </ul>
  <ul>
    <li class="noBorder">© 2012 Event Orbit. All Rights Reserved </li>
    <li><a href="#">Terms</a></li>
    <li><a href="#">Privacy</a></li>
    <li><a href="#">Entity Index</a></li>
  </ul>
</footer>

</body>
</html>