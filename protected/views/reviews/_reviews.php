<?php    
    $date = strtotime($data->date_created);
    $month = date("M", $date);
    $day = date("d", $date);
    $year = date("Y", $date);
    
    $final_date = date("l, F, d, Y", $date);
    
    /*
    $date = strtotime($event->start_date);
$month = date("M", $date);
$day = date("d", $date);
$year = date("Y", $date);
$final_start_date = date("l, F d, Y", $date);




$end_date = strtotime($event->end_date);
$end_month = date("M", $end_date);
$end_day = date("d", $end_date);
$end_year = date("Y", $end_date);
$final_end_date = date("l, F d, Y", $end_date);



$start_time = $event->start_time;
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




$end_time = $event->end_time;
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
    
    
    */
    
    
    
    ?>
      
    <div class="loopEvents">
      <div class="fL"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-preview-th.jpg" alt="" width="100" height="100"></div>
      <div class="fR">
        <div class="reviewBtn">
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
            
            
        </div>
        <p class="noMar">Reviewed on <?php echo $final_date;?> </p>
        <h2><?php echo CHtml::link($data->creator->firstName.' '. substr($data->creator->lastName, 0, 1), array('user/'.$data->creator->lookup)); ?>.</h2>
        <p> <strong>has a total of <?php echo $data->creator->reviewsCount;?> reviews.</strong> <br>
            <span class="style1"><?php echo $data->creator->city.', '.$data->creator->state; ?></span></p>
        <p> <?php echo $data->review;?></p>
      </div>
      <div class="clear"></div>
    </div>