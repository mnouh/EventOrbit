<?php
$this->pageTitle=Yii::app()->name . ' - Info for '.$model->name;
$lat = $model->lat;
$lng = $model->lng;
$biz_name = $model->name;
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
<div class="eventDetails noPadd">
<div class="topMenu">
  <ul>
    <li><?php echo CHtml::link('Events', array("business/$model->bizurl")); ?></li>
    <li><?php echo CHtml::link('Reviews', array("reviews/$model->bizurl"), array('class'=>'sel')); ?></li>
    <li><a href="#">Statistics</a></li>
  </ul>
  <div class="clear"></div>
  </div>
  <div class="yesPadd">
<div class="leftFloat">
<div class="topArea">
<div class="fL">
  <h2><?php echo $model->name;?> </h2>
  <div class="reviewBtn">
      
      <?php
      $business_rating = $model->calculateReview();
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
          echo $model->name.' has not been rated yet, be the first to review.<br>';
          echo CHtml::link('Write a Review', array("reviews/create/$model->bizurl"));
          
      }
      ?>
      
      
      <br>
    <?php if($reviewed_status) {?><em>based on <?php echo $model->reviewCount;?> reviews</em><?php }?></div>
  <div class="BusinessAddress" style="margin-bottom:10px;">
  <div><strong>Address : </strong></div>
  <div><?php echo $model->address0;?></div>
  <div><?php echo $model->address1;?></div>
  <div><?php echo $model->address2;?></div>
  <div><?php echo $model->address3;?></div>
  <div><?php echo $model->display_phone;?></div>
  </div>
  <p><strong>Categories: </strong><br>
  <?php
  foreach($category as $cat) {
      
      echo "<a href='#'>$cat</a>, ";
  }
  ?>
  </p>
  <p> <strong>First Reviewer : </strong><br>
      <?php if($model->first_reviewed_by === NULL) { echo 'Be the first to review.'; } else { $reviewed_by = $model->findFirstReviewer(); echo Chtml::link($reviewed_by->firstName.' '.substr($reviewed_by->lastName, 0, 1).'. ', array('user/'.$reviewed_by->lookup));}?></p>
  <p>    <strong>Website : </strong><br>
    No Website in our records at this time.</p>
  <p>    <strong>Other Information : </strong><br>
    Free</p>
  <p>    <strong>Transportation</strong><br>
    Transportation Information will be added later.
  </p>
</div>
<div class="fR">
<div class="eventImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-preview.jpg" alt=""></div>
<div class="eventImgList">
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/member1-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/member-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="eventImgListImg"><img src="<?php echo Yii::app()->baseUrl;?>/images/no-img-th.jpg" alt=""></div>
<div class="clear"></div>
</div>
<input name="Submit32" type="submit" class="submitButtonAll" value="Add A Photo">
</div>
<div class="clear"></div>
</div>
<div class="btmArea"> 
  <p><strong>Information from the owner : </strong><br>
    Park Here is Openhouse Gallery's response to frigid winter. It's a pop-up park in the heart of Nolita
    that's blooming when nothing else is. Park Here has plush grass, beautiful foliage, picnic blankets, oversized 
    bean bags and hammocks. Blazing fast WiFi, mornings exclusively for moms and their kids and kicking off with a
    Rolling Stone concert series. This park has plenty of food vendors, BBQ tasting, free wine tastings, free coffee, outdoor music series, and hammocks. Located on 201 Mulberry St. between Spring + Kenmare. </p>
  <p>
    <input name="Submit3" type="submit" class="submitButtonAll" value="Send to A Friend">
    <?php echo CHtml::link('Create an Event', array("events/create/$model->bizurl"), array('class'=>'submitButtonAll')); ?>
    <?php echo CHtml::link('Write a Review', array("reviews/create/$model->bizurl"), array('class'=>'submitButtonAll')); ?>
  <div>
    <div style="none" id="like">
                
                
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
                                array('class' => 'submitButtonAll')
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
                                array('class'=>'submitButtonAll')
                                );
                        
                        
                    }
                }
                ?>
                <?php if($model->userlikes == 0) echo "0 people like this."; if($model->userlikes == 1) echo "1 person likes this."; if($model->userlikes > 1) echo $model->userlikes.' people like this.';?>
        
        
            </div>
  </div>
  </p>
</div>
  <div>
  <h2 class="hdings">All Reviews at <?php echo $model->name; ?> (<?php echo $model->reviewCount;?>) </h2>
  <div>

      <?php
             
             
    $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_reviews',   // refers to the partial view named '_post'
    'pagerCssClass' => 'page',
        'pager'=>array(
            'htmlOptions' => array('class' => 'pagings'),
	),
    //'cssFile'=> Yii::app()->baseUrl.'/styles/css.css',
    'sortableAttributes'=>array(
        'rating',
        'date_created'=>'Post Time',
        //'' => CHtml::link('Clear Filters', array('user/'.$model->lookup.'?Reviews_page=pager')),
    ),
));
    
    
       ?>
      
  </div>
</div>
</div>
<div class="rightFloat">
<div class="blocks">
  <div class="headings">
    <table width="100%" border="0" cellpadding="0" cellspacing="3">
      <tr>
        <td width="100"><strong>Similar Places </strong></td>
        <td class="txtRht"><select name="select">
            <option selected>Distance</option>
            <option>Resturants</option>
            <option>Nightlife</option>
          </select>
        </td>
      </tr>
    </table>
  </div>
  <div class="paddTop">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
      
        <?php
    foreach($venues as $place) {
    ?>    
        
        <tr>
        <td>
            <a href="<?php echo $place->bizurl;?>"><?php echo $place->name;?></a><br> 
        
            <h4>Events: <?php echo $place->publicEventCount.'';?>&nbsp;&nbsp;<?php echo CHtml::link('Review', array("reviews/create/$place->bizurl"));?></h4>
        
        </td>
        
        <td width="70"><span class="review">
                
                <?php
      $business_rating = $place->calculateReview();
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
    <?php if($reviewed_status) {?><em><?php echo $place->reviewCount; echo ($place->reviewCount == 1) ? ' Review':' Reviews'?></em><?php }?>
        
        
        
        </td>
      </tr>
            <?php
        }
    
    ?>
    </table>
  </div>
  <div class="txtRht">
    <input name="Submit3322" type="submit" class="submitButtonAll" value="See All">
  </div>
</div>
<div class="blocks">
    <div id="mapSimple" style="width:300px; height:300px; background:white;"> &nbsp;</div></div>
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
    <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
    <em>144 Reviews</em></td>
      </tr>
      <tr>
        <td><a href="#">89Bytes Web Studio </a></td>
        <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>78 Reviews</em></td>
      </tr>
      <tr>
        <td><a href="#">Notes for us </a></td>
        <td><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
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
        <td width="70"><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>144 Reviews</em></td>
      </tr>
      <tr>
        <td><em>Feb 17 </em><br>
          <a href="#">
          89Bytes Super Event </a></td>
        <td><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>78 Reviews</em></td>
      </tr>
      <tr>
        <td><em>Feb 23 </em><br>
        <a href="#">Notes for us Educational Event </a></td>
        <td><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>93 Reviews</em></td>
      </tr>
    </table>
  </div>
  <div class="txtRht">
    <input name="Submit33222" type="submit" class="submitButtonAll" value="See All">
  </div>
</div>
</div>
</div>
<div class="clear"></div>
</div>
  
</section>