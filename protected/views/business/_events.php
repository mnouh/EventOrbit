<?php
    
    $date = strtotime($data->start_date);
$month = date("M", $date);
$day = date("d", $date);
$year = date("Y", $date);
$final_start_date = date("l, F d, Y", $date);




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
      
    <div class="loopEvents">
      <div class="fL"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-preview-th.jpg" alt="" width="100" height="100"></div>
      <div class="fR">
       <h2><?php echo CHtml::link($data->name, array("event/$data->eventurl")); ?></h2>
        <p class="noMar">Submitted By: <?php echo Chtml::link($data->creator->firstName.' '.substr($data->creator->lastName, 0, 1).'.', array('user/'.$data->creator->lookup));?></p>
        <p> <strong>Start Time: <?php echo $final_start_date; ?> at <?php echo date("g:i A", $time); ?> - <br> End Time:
<?php echo $final_end_date; ?> at <?php echo date("g:i A", $finished_end_time);?></strong> <br>
        <div class="eventInfo">
    <strong>RSVP: </strong> <?php if(!Yii::app()->user->isGuest) {?> <span class="green"><div id="status<?php echo $data->id;?>" style="display:inline;">
  <?php if($data->statusRsvp()) { echo 'Yes'; } else { echo 'No';} ?></div></span>

    <?php
		echo CHtml::ajaxSubmitButton(
                                        'Change',
                                        array('events/adduser?id='.$data->id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#status$data->id').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=>'submitButtonAll')
                                );
         
                ?>



 <?php } else { echo CHtml::link('You need to be logged in', array('account/login'));} ?>  </div></p>
        <p> <?php echo $data->details; ?></p>
      </div>
      <div class="clear"></div>
    </div>
     