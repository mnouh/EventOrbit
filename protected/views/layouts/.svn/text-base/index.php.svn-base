<?php 

if(Yii::app()->params['public'] == true) {
                
                $this->beginContent('/layouts/indexpage');
                
                
}
else if(Yii::app()->params['public'] == false) {
    
    $this->beginContent('/layouts/secondary');
    
}
            
           ?>
<div class="container">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>