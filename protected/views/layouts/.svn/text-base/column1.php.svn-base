<?php 


if(Yii::app()->params['public'] == true) {
                
                $this->beginContent('/layouts/public');
                
                
}
else if(Yii::app()->params['public'] == false) {

    if(Yii::app()->params['private_clear'] == true) {
    
    }
    else {
    
    $this->beginContent('/layouts/private');
    }
}
            
           ?>
<div class="container">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>