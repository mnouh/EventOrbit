<?php
if(Yii::app()->params['public'] == true) {
                
                $this->beginContent('/layouts/public');
                
                
}
else if(Yii::app()->params['public'] == false) {
    
    if(Yii::app()->params['layout_clean'] == true) {
        
        $this->beginContent('/layouts/private_clean');
        
    }
    else {
    
    $this->beginContent('/layouts/private');
    }
}

?>
<div class="fL">
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
</div>

    <div class="floatRight">
	
        <div>
        <h3><span class="cal">upcoming</span></h3>
        <div class="blocks">No upcoming assignments<br />
            or events</div>
    </div>
    <div>
        <h3>your courses</h3>
        <div class="blocks">
            <ul>
                <li><a class="side" href="#">Computer Science: 01</a></li>
                <li><a class="side" href="#">Operating Systems: 01</a></li>
            </ul>
        </div>
    </div>
        <div>
        <h3>User Menu</h3>
        <div class="blocks">
            <ul>
               
                        
                <?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
            </ul>
        </div>
    </div>
        <div>
        <h3>Post Menu</h3>
        <div class="blocks">
            <ul>
                <?php $this->widget('TagCloud', array(
				'maxTags'=>Yii::app()->params['tagCloudCount'],
			)); ?>

			<?php $this->widget('RecentComments', array(
				'maxComments'=>Yii::app()->params['recentCommentCount'],
			)); ?>
            </ul>
        </div>
    </div>

        
        
        
        
        <?php
        /*
        
        <div class="span-6 last">
		<div id="sidebar">
			<?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>

			<?php $this->widget('TagCloud', array(
				'maxTags'=>Yii::app()->params['tagCloudCount'],
			)); ?>

			<?php $this->widget('RecentComments', array(
				'maxComments'=>Yii::app()->params['recentCommentCount'],
			)); ?>
		</div><!-- sidebar -->
	</div>
         */
        ?>
        
</div>        
<?php $this->endContent(); ?>
