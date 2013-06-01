
<?php
    
    $date = strtotime($data->date_created);
    $month = date("M", $date);
    $day = date("d", $date);
    $year = date("Y", $date);
    
    $final_date = date("l, F, d, Y", $date);
?>
<div class="loopEventsUser">
            <div class="fL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-preview-th.jpg" alt="" width="100" height="100"></div>
            <div class="fR">
              <h2><?php echo CHtml::link($data->marker->name, array('business/' . $data->marker->bizurl));?></h2>
              <?php
            
            for($i = 0; $i < $data->rating; $i++) {
                
                ?>
            
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full.png" alt="" width="20" height="20" border="0"></a>
            <?php
                
                
            }
            
            $rating = 5 - $data->rating;
            for($j = 0; $j < $rating; $j++) {
                ?>
                
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="" width="20" height="20" border="0"></a>
                <?php
            }
            
            ?>
              <p class="noMar">Reviewed on <?php echo $final_date;?> </p>
              <p> <strong>Wednesday, Jan 4, 12:00 pm - Sunday, Mar 4, 12:00 pm</strong> <br>
                  <span class="style1"><a href="#">Museum Of The Moving Image</a>, Astoria, NY</span></p>
              <p> <?php echo $data->review;?></p>
            </div>
            <div class="clear"></div>
</div>