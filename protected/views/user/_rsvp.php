<?php
$date = strtotime($data->start_date);
$month = date("M", $date);
$day = date("d", $date);
$year = date("Y", $date);
$final_start_date = date("l, F d, Y", $date);


$created_date = strtotime($data->date_created);

$date_created = date("l, F d, Y", $created_date);

$end_date = strtotime($data->end_date);
$end_month = date("M", $end_date);
$end_day = date("d", $end_date);
$end_year = date("Y", $end_date);
$final_end_date = date("l, F d, Y", $end_date);



$start_time = $data->start_time;
//echo $start_time.'<br>';
$start_time = $start_time / 60;

$start_time = number_format($start_time, 2);
//echo $start_time.'<br>';


$hour = floor($start_time);
$min = $start_time - $hour;



$min*=60;

//echo $min.'<br>';
//echo $hour.'<br>';
$start_time = $hour . ':' . $min;
$time = strtotime($start_time);




$end_time = $data->end_time;
//echo $end_time.'<br>';
$end_time = $end_time / 60;

$end_time = number_format($end_time, 2);
//echo $start_time.'<br>';


$end_hour = floor($end_time);
$end_min = $end_time - $end_hour;



$end_min*=60;

//echo $min.'<br>';
//echo $hour.'<br>';
$end_time = $end_hour . ':' . $end_min;
$finished_end_time = strtotime($end_time);
?>
<div class="loopEventsUser">
  <div class="fL"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-preview-th.jpg" alt="" width="100" height="100"></div>
  <div class="fR">
    <h2><?php echo Chtml::link($data->name, array('event/'.$data->eventurl));?></h2>
    <p> <strong><?php echo $final_start_date; ?> at <?php echo date("g:i A", $time); ?> -
<?php echo $final_end_date; ?> at <?php echo date("g:i A", $finished_end_time); ?></strong> <br>
        <span class="style1"><?php echo CHtml::link($data->marker->name, array('business/'.$data->marker->bizurl)); ?>, <?php echo $data->marker->city.', '.$data->marker->state_code;?>
            <br>
            
            <?php
      $business_rating = $data->marker->calculateReview();
      //echo 'Rating: '. $business_rating.'<br>';
      $reviewed_status = false;
      if($business_rating != 0) {
          
          $reviewed_status = true;
          $business_rating = number_format($business_rating, 2);
          $pieces = explode(".", $business_rating);
          
          $right = 0;
          $left = $pieces[0];
          
          $right = $pieces[1];
          
            
            for($i = 0; $i < $left; $i++) {
                
                ?>
            
            <a style="float:left;" href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="<?php echo $business_rating;?>" width="10" height="10" border="0"></a>
            <?php
                
                
            }
            
            if($right > 0) {
                ?>
                <a style="float:left;" href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-half-sm.png" alt="<?php echo $business_rating;?>" width="10" height="10" border="0"></a>
                
            <?php
            $rating = 5 - ($left+1);
            for($j = 0; $j < $rating; $j++) {
                ?>
                
            <a style="float:left;"href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="<?php echo $business_rating;?>" width="10" height="10" border="0"></a>
                <?php
            }
            
            }
            else {
                
                $rate = 5 - $left;
            for($x = 0; $x < $rate; $x++) {
                ?>
                
            <a style="float:left;" href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="<?php echo $business_rating;?>" width="10" height="10" border="0"></a>
                <?php
            }
                
                
            }
            
          
          
          
      }
      else {
          ?>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a>
          <?php 
          echo $data->marker->name.' has not been rated yet, be the first to review.<br>';
          echo CHtml::link('Write a Review', array('reviews/create/'.$data->marker->bizurl));
          
      }
      ?>
            <br>
    <?php if($reviewed_status) {?><em>based on <?php echo $data->marker->reviewCount;?> reviews</em><?php }?>
        </span></p>
    <p> <?php echo $data->details; ?></p>
    <p><strong>Submitted By:</strong>  <?php echo CHtml::link($data->creator->firstName.' '.substr($data->creator->lastName, 0, 1).'.', array('user/'.$data->creator->lookup)); ?> on <?php echo $date_created;?> &nbsp;|&nbsp; <span class="orangeTxt"><?php echo $data->countrsvp; ?> Interested </span></p>
    </div>
  <div class="clear"></div>
  </div>