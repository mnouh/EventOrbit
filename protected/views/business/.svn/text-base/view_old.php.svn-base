<?php
$this->pageTitle=Yii::app()->name . ' - Info for '.$model->name;
/*$this->breadcrumbs=array(
	'Business'=>array('index'),
	$model->name,
);
*/
$this->menu=array(
	array('label'=>'List Marker', 'url'=>array('index')),
	array('label'=>'Create Marker', 'url'=>array('create')),
	array('label'=>'Update Marker', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Marker', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Marker', 'url'=>array('admin')),
);
?>


<section>
<div class="floatLeft">
<div class="listings">
<div class="lists">

<div class="compLst">
<div class="floatLeft"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-preview.jpg" alt="">
    
        <ul style="list-style-type: none;">
            <li><?php echo CHtml::link('Create Event', array("events/create/$model->bizurl"), array('class'=>'statlink')); ?></li>
            <li><?php echo CHtml::link('Write a Review', array("events/create/$model->bizurl"), array('class'=>'statlink')); ?></li>
            <div id="like">
            <li>
                
                
                <?php
                if(!Yii::app()->user->isGuest) {
                    
                    if(!$model->findUser()) {
		echo CHtml::ajaxLink(
                                        'Like',
                                        array('business/likebiz?id='.$model->id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#like').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array()
                                );
         
                    }
                    else {
                        
                        echo CHtml::ajaxLink(
                                        'UnLike',
                                        array('business/likebiz?id='.$model->id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#like').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array()
                                );
                        
                        
                    }
                }
                ?>
                
                
            </li>
            
            <li><?php if($model->userlikes == 0) echo "0 people like this."; if($model->userlikes == 1) echo "1 person likes this."; if($model->userlikes > 1) echo $model->userlikes.' people like this.';?></li>
            </div>
        </ul>
        
    
    <div style="margin-top:5px;">
        <ul style="list-style-type: none;">
        <li>Rating: <?php if($model->rating == NULL) { echo 'Not Rated';} else { echo $model->rating; }?></li>
        </ul>
    </div>
</div>
<div class="fL">
  <div class="mainHead"><?php echo $model->name; ?></div>
  <div class="contacts"><?php echo $model->address0;?>
  <div><?php echo $model->address1;?></div>
  <div><?php echo $model->address2;?></div>
  <div><?php echo $model->address3;?></div>
  <div><?php echo $model->display_phone;?></div>
  
  </div>
  <div class="otherDivs"><?php
  foreach($category as $cat) {
      
      echo "<a href='#'>$cat</a>, ";
  }
  ?></div>
  <div class="lastDivs"><strong>Other Information</strong></div>
  <div class="content">
      <div>Transportation:</div>
    <div>More Information will be added later</div>
  </div>
</div>
<div class="fR">
    <?php //Here goes the reviews, create event button and etc ?>
</div>

<div class="clear"></div>
<h3 style="font-size:16px;">Public Events(<?php echo $model->publicEventCount;?>)</h3>

</div>
    <?php

foreach($model->publicevents as $event) {
    
    $date = strtotime($event->start_date);
    $month = date("M", $date);
    $day = date("d", $date);
    $year = date("Y", $date);
    $final_start_date = date("M d, Y", $date);
    
    
    
    
    $end_date = strtotime($event->end_date);
    $end_month = date("M", $end_date);
    $end_day = date("d", $end_date);
    $end_year = date("Y", $end_date);
    $final_end_date = date("M d, Y", $end_date);
    
    
    
    $start_time = $event->start_time;
    //echo $start_time.'<br>';
    $start_time = $start_time/60;
    
    $start_time = number_format($start_time,2);
    //echo $start_time.'<br>';
    
    
    $hour = floor($start_time);
    $min = $start_time - $hour;
    
    
    
    $min*=60;
    
    //echo $min.'<br>';
    //echo $hour.'<br>';
    $start_time = $hour.':'.$min;
    $time = strtotime($start_time);
    
    
    
    
    $end_time = $event->end_time;
    //echo $end_time.'<br>';
    $end_time = $end_time/60;
    
    $end_time = number_format($end_time,2);
    //echo $start_time.'<br>';
    
    
    $end_hour = floor($end_time);
    $end_min = $end_time - $end_hour;
    
    
    
    $end_min*=60;
    
    //echo $min.'<br>';
    //echo $hour.'<br>';
    $end_time = $end_hour.':'.$end_min;
    $finished_end_time = strtotime($end_time);
    
    
    
    
    
    
    ?>
     
    <div class="snglLst">
<div class="floatLeft"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-preview.jpg" alt=""></div>
<div class="fL"><div class="mainHead"><?php echo CHtml::link($event->name, array("event/$event->eventurl")); ?></div>
  <div><strong>Start Time :</strong> <?php echo date("g:i A", $time);?> on <?php echo $final_start_date; ?></div>
  <div><strong>End Time :</strong> <?php echo date("g:i A", $finished_end_time);?> on <?php echo $final_end_date; ?></div>
  <div><strong>Where :</strong> <?php echo $model->address;?> ( <a href="#">Map it</a> )</div>
  <div><strong>Submitted By : </strong><a href="#"><?php echo $event->creator->firstName;?></a></div>
  <div>
    <strong>RSVP : </strong><?php if(!Yii::app()->user->isGuest) {?> <span class="green"><div id="status<?php echo $event->id;?>" style="display:inline;">
  <?php if($event->statusRsvp()) { echo 'Yes'; } else { echo 'No';} ?></div></span>

    <?php
		echo CHtml::ajaxSubmitButton(
                                        '( Change )',
                                        array('events/adduser?id='.$event->id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#status$event->id').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array()
                                );
         
                ?>



 <?php } else { echo CHtml::link('You need to be logged in', array('account/login'));} ?>  </div>
    <div>
    <strong>Description : </strong> <?php echo $event->details;?> </div>
  
</div>
<div class="fR">
<div class="top"><?php echo $month; ?><br>
  <span class="green"><?php echo $day; ?></span><br><?php echo $year;?></div>
<div class="btm"><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/facebook.png" alt="" width="16" height="16" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/twitter.png" alt="" width="16" height="16" border="0"></a></div>
</div>
<div class="clear"></div>
</div>
<?php
    }

?>
</div>
</div>
</div>
<div class="floatRight">
  <h2>Similar Places
  </h2>
  <ul>
    <?php
    foreach($venues as $place) {
        
        echo "<li><a href='$place->bizurl'>$place->name</a></li>";
    }
    ?>
  </ul>
  </div>
<div class="clear"></div>
</section>
