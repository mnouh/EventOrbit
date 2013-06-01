<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/styles/css.css" />
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl;?>/images/favicon.ico" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>
<body>
<header>
  <div class="inside">
    <h1 class="logo"><a>Event Orbit</a></h1>
    <?php if (Yii::app()->user->isGuest) {?>
	<?php if(Yii::app()->params['login'] == true) { ?><div class="loginTop"><?php echo CHtml::link('Login', array('account/login'), array('class'=> 'loginbtn')); ?></div><?php }?>
        <?php if(Yii::app()->params['signup'] == true) { ?><div class="signupTop"><?php echo CHtml::link('Signup', array('account/signup'), array('class'=> 'loginbtn'));} ?></div>
        <?php } else { ?>
        <div class="afterloginTop">Hello <?php echo CHtml::link(Yii::app()->user->firstName.' '. Yii::app()->user->lastName, array('user/'.Yii::app()->user->lookup)); ?>   |   <?php echo CHtml::link('Logout', array('account/logout'));?>  |   <?php echo CHtml::link('Profile', array('account/profile'));?></div><?php } ?>
	<fieldset id="signin_menu" style="display:none;">
				               <form action="" method="post">
				                 <div style="margin:0;padding:0;display:inline"></div>
				                  <label for="username"><strong>Username or email</strong></label>
								  <input id="user_email" name="user[email]" size="30" type="text">
								   <label for="password"><strong>Password</strong></label>
								  <input id="user_password" name="user[password]" size="30" type="password">
									  
					              <p class="remember">
					                <input id="signin_submit" value="Sign in" tabindex="6" type="submit">
					                <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
					                <label for="remember">Remember me</label>
					              </p>
					              
					              <p class="forgot"> <a href="#">Forgot your password?</a></p>
					              
					              </form>							  </fieldset>
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
    <li class="noBorder">© 2012 We Out. All Rights Reserved </li>
    <li><a href="#">Terms</a></li>
    <li><a href="#">Privacy</a></li>
    <li><a href="#">Entity Index</a></li>
  </ul>
</footer>

</body>
</html>