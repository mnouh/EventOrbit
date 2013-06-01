<?php
/*
  $this->breadcrumbs=array(
  'Events'=>array('index'),
  $model->id,
  );

  $this->menu=array(
  array('label'=>'List Events', 'url'=>array('index')),
  array('label'=>'Create Events', 'url'=>array('create')),
  array('label'=>'Update Events', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete Events', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage Events', 'url'=>array('admin')),
  );
 * 
 */

//$cs=Yii::app()->clientScript;  
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/event.js', CClientScript::POS_HEAD);  

$lat = $model->marker->lat;
$lng = $model->marker->lng;
$biz_name = $model->marker->name;

$date = strtotime($model->start_date);
$month = date("M", $date);
$day = date("d", $date);
$year = date("Y", $date);
$final_start_date = date("l, F d, Y", $date);




$end_date = strtotime($model->end_date);
$end_month = date("M", $end_date);
$end_day = date("d", $end_date);
$end_year = date("Y", $end_date);
$final_end_date = date("l, F d, Y", $end_date);



$start_time = $model->start_time;
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




$end_time = $model->end_time;
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

<script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBYyogbtGgj4TloAVbB0MJC8o2JIrjwlvc&sensor=true">
</script>
<script type="text/javascript">
    //<![CDATA[
    var map;
    var myLat = <?php if (isset($lat)) {
    echo $lat;
} ?>;
    var myLng = <?php if (isset($lng)) {
    echo $lng;
} ?>;
    var loc_name = '<?php echo $biz_name; ?>';
    var infoWindow;
    
    var comment = $("#comments").val();
    

    var locationSelect;
    var mapItSelect;

    $(document).ready(function() {
        load();

            $('#update_discussion').click(function(){
                
                
                jQuery.ajax({
                    'type':'POST',
                    'url':'http://localhost/~mnouh/event/discuss',
                    'cache':false,
                    'data':$("form").serialize(),
                    'success':
                        function(html){
                        $('div#reviewDiscussion').prepend(html);
                        $("textarea#comments").val('');
                        
                    }});
                
                
                });
        
        });

        function load() {    
        
            var myLatlng = new google.maps.LatLng(myLat,myLng);
            var myOptions = {
                zoom: 14,
                center: myLatlng,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP 
            }
            map = new google.maps.Map(document.getElementById("mapSimple"), myOptions);

            var contentString = '<b>'+loc_name+'</b>';

            infowindow = new google.maps.InfoWindow({
                content: contentString,
                position: myLatlng
            });
            var marker = new google.maps.Marker({
                position: myLatlng,
                title:"Hello World!"
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            }); 
        }
    
    
    
   
</script>
<section>
    <div class="eventDetails">
        <div class="leftFloat">
            <div class="topArea">
                <div class="fL">
                    <h2><?php echo $model->name; ?> at <?php echo $model->marker->name; ?> </h2>
                    <div class="reviewBtn">
                        
                        <?php
      $business_rating = $model->marker->calculateReview();
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
            
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
            <?php
                
                
            }
            
            if($right > 0) {
                ?>
                <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-half.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
                
            <?php
            $rating = 5 - ($left+1);
            for($j = 0; $j < $rating; $j++) {
                ?>
                
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
                <?php
            }
            
            }
            else {
                
                $rate = 5 - $left;
            for($x = 0; $x < $rate; $x++) {
                ?>
                
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
                <?php
            }
                
                
            }
            
          
          
          
      }
      else {
          ?>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a>
            <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none.png" alt="<?php echo $business_rating;?>" width="20" height="20" border="0"></a><br>
          <?php 
          echo $model->marker->name.' has not been rated yet, be the first to review.<br>';
          echo CHtml::link('Write a Review', array('reviews/create/'.$model->marker->bizurl));
          
      }
      ?>
            <br>
    <?php if($reviewed_status) {?><em>based on <?php echo $model->marker->reviewCount;?> reviews</em><?php }?>
                        
                    </div>
                    <p><strong>When : </strong><br>
                        <?php echo $final_start_date; ?> at <?php echo date("g:i A", $time); ?> - <br>
<?php echo $final_end_date; ?> at <?php echo date("g:i A", $finished_end_time); ?></p>
                    <p> <strong>Where : </strong><br>

                        <?php echo CHtml::link($model->marker->name, array('business/' . $model->marker->bizurl)); ?><br>
                        <span class="review">
                        
                            <?php
      $business_rating = $model->marker->calculateReview();
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
          echo 'Not rated';
          //echo CHtml::link('Write a Review', array("reviews/create/$model->bizurl"));
          
      }
      ?>
                            
                        </span><br>
                        <?php if($reviewed_status) {?><em>based on <?php echo $model->marker->reviewCount;?> reviews</em><?php }?>
                        <?php echo $model->marker->address0; ?><br>
                        <?php echo $model->marker->address1; ?><br>
<?php echo $model->marker->address2; ?><br>
<?php echo $model->marker->address3; ?>
                        <br>
<?php echo $model->marker->display_phone; ?></p>
                    <p>    <strong>How : </strong><br>
                        Official Website</p>
                    <p>    <strong>Cost : </strong><br>
                        Free</p>
                    <p>    <strong>Submitted by : </strong><br>
                        <a href="#" class="orangeTxt"><?php echo CHtml::link($model->creator->firstName . ' ' . substr($model->creator->lastName, 0, 1) . '.', array('user/'.$model->creator->lookup)); ?></a>   <br>
                        <?php echo CHtml::link('See all of '.$model->creator->firstName . ' ' . substr($model->creator->lastName, 0, 1) . ".'s events »", array('user/events/'.$model->creator->lookup)); ?></p>
                </div>
                <div class="fR">
                    <div class="eventImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-preview.jpg" alt=""></div>
                    <div class="eventImgList">
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member1-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="eventImgListImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                        <div class="clear"></div>
                    </div>
                    <input name="Submit32" type="submit" class="submitButtonAll" value="Add A Photo">
                </div>
                <div class="clear"></div>
            </div>
            <div class="btmArea"> 
                <p><strong>What / Why : </strong><br>
<?php echo $model->details; ?> </p>
                <p>
                    <input name="Submit3" type="submit" class="submitButtonAll" value="Send to A Friend">
                </p>
            </div>
            <div class="ReviewArea">
                <h2>Discuss The Event </h2>
                
                <div class="areaTxt">
                    
                    <?php if(!Yii::app()->user->isGuest) { ?>
                    <form>
                    <textarea id="comments" name="comments" cols="" rows="4" class="txtArea"></textarea>
                    <div class="txtRht">

                        <input name="event_id" style="display:none;"value="<?php echo $model->id; ?>">
                        <a id ="update_discussion" class="submitButtonAll">Share</a>
                        </form>




                    </div>
                    <?php } ?>
                </div>
                <div id="reviewDiscussion">
                    <?php foreach($model->discussion as $discussion) { ?>
                    <div class="reviews">
                        <div class="fL">
                            <div class="imgBox"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                            <div class="status"><a href="#"><strong><?php echo CHtml::link($discussion->creator->firstName.' '.substr($discussion->creator->lastName, 0, 1).'.', array('user/'.$discussion->creator->lookup)); ?></strong></a><br>
                                <?php echo CHtml::link($discussion->creator->reviewsCount.' Reviews', array('user/'.$discussion->creator->lookup)); ?> </div>
                            <div class="clear"></div>
                        </div>
                        <div class="fR"> <?php echo CHtml::link($discussion->creator->firstName.' '.substr($discussion->creator->lastName, 0, 1), array('user/'.$discussion->creator->lookup)); ?>. says:
                            <p><?php echo $discussion->message;?></p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php }?>
                    
                    <div class="txtRht">
                        <input name="Submit322" type="submit" class="submitButtonAll" value="Reply"></div>
                </div>
            </div>
        </div>
        <div class="rightFloat">
            <div class="blocks">
                <div class="nowrapTxt">Are You Interested? </div>

                <div class="fR">
                    <?php
                    echo CHtml::ajaxSubmitButton(
                            'Change', array('events/adduser?id=' . $model->id), array('success' => "js:function(data) {
                                                    jQuery('div#status$model->id').html(data);
                                               }",
                        //'update'=>'#successMessage',
                        'beforeSend' => 'function() {}',
                        //'validated' => 'function() {changeButton();}',
                        'complete' => 'function() {}',
                        'type' => 'POST'
                            ), array('class' => 'submitButtonAll')
                    );
                    ?>

                </div>
                <div class="floatLeft">
                    <strong>RSVP : </strong><?php if (!Yii::app()->user->isGuest) { ?> <span class="green"><div id="status<?php echo $model->id; ?>" style="display:inline;">
                                <?php if ($model->statusRsvp()) {
                                    echo 'Yes';
                                } else {
                                    echo 'No';
                                } ?></div></span>

<?php } else {
    echo CHtml::link('You need to be logged in', array('account/login'));
} ?>  </div>
                <div class="clear"></div>
            </div>
            <div class="blocks"><div class="headings"><strong>Who is Attending? </strong><em><?php if ($model->countrsvp == 0) {
                    echo 'No Responses';
                } else if ($model->countrsvp == 1) {
                    echo '1 response';
                } else {
                    echo $model->countrsvp . ' Responses.';
                } ?></em> </div>

<?php
foreach ($model->rsvps as $rsvp) {

    echo $rsvp->user->firstName . '<br>';
}
?>
                <div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member1-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member-th.jpg"></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member1-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member-th.jpg"></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-img-th.jpg" alt=""></div>
                    <div class="listings"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/member-th.jpg"></div>
                    <div class="clear"></div>
                    <div class="txtRht">
                        <input name="Submit332" type="submit" class="submitButtonAll" value="See All">
                    </div>
                </div>
            </div>
            <div class="blocks"><div class="map">
                    <div id="mapSimple" style="width:300px; height:300px; background:white;"> &nbsp;</div></div></div>
            <div class="blocks">
                <div class="headings">
                    <table width="100%" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="100"><strong>Show Nearby </strong></td>
                            <td class="txtRht"><select name="select">
                                    <option selected>Businesses</option>
                                    <option>Resturants</option>
                                    <option>Nightlife</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="paddTop">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
                        <tr>
                            <td><a href="#">Outdoor Bound Adventures</a> </td>
                            <td width="70"><span class="review">
                                    <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>144 Reviews</em></td>
                        </tr>
                        <tr>
                            <td><a href="#">89Bytes Web Studio </a></td>
                            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>78 Reviews</em></td>
                        </tr>
                        <tr>
                            <td><a href="#">Notes for us </a></td>
                            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>93 Reviews</em></td>
                        </tr>
                    </table>
                </div>
                <div class="txtRht">
                    <input name="Submit3322" type="submit" class="submitButtonAll" value="See All">
                </div>
            </div>
            <div class="blocks">
                <div class="headings"><strong>Other Events This Week </strong><em></em> </div>
                <div class="paddTop">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
                        <tr>
                            <td><em>Feb 16 </em><br>
                                <a href="#">Outdoor Bound Mega Event </a> </td>
                            <td width="70"><span class="review"> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>144 Reviews</em></td>
                        </tr>
                        <tr>
                            <td><em>Feb 17 </em><br>
                                <a href="#">
                                    89Bytes Super Event </a></td>
                            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>78 Reviews</em></td>
                        </tr>
                        <tr>
                            <td><em>Feb 23 </em><br>
                                <a href="#">Notes for us Educational Event </a></td>
                            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
                                <em>93 Reviews</em></td>
                        </tr>
                    </table>
                </div>
                <div class="txtRht">
                    <input name="Submit33222" type="submit" class="submitButtonAll" value="See All">
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

</section>