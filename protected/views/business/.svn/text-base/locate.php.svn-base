<div id="info">
<?php
$index = 0;
foreach ($venues as $bus) {
                    ?>

                    <div class="snglLst">
                        <div class="floatLeft"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-preview.jpg" alt="<?php echo $bus->name; ?>"><div><strong><div class="frame">Distance: <?php echo round($bus->distance, 1); ?> miles</strong></div></div></div>
                        <div class="fL">
                            <div style="float:left; width:200px;">  
                                <div class="mainHead"><a href="<?php echo $bus->bizurl; ?>"><?php echo $bus->name; ?></a></div>
                                <div><?php echo $bus->address0; ?> ( <a id="mapit" href="#" onClick="mapIt('<?php echo $index; ?>');">Map it</a> )</div>
                                <div><?php echo $bus->address1; ?></div>
                                <div><?php echo $bus->address2; ?></div>
                                <div><?php echo $bus->address3; ?></div>
                                <div><strong>Phone  :</strong> <?php echo $bus->display_phone; ?></div>
                                <div><strong>RSVP   : </strong> <span class="green">YES</span> ( <a href="#">Change</a> )</div>
                            </div>

                            <div style="float:left">
                                <div class="mainHead"><a href="#">&nbsp;</a></div>
                                <div>Reviews: <?php
                    $reviews = (empty($bus->num_reviews)) ? '(' . $bus->num_reviews . ') <a class="statlink" href="#">Be the first to review</a>' : '(' . $bus->num_reviews . ') Write a Review';
                    echo $reviews;
                    ?></div>
                                <div>Rating: <?php
                    $rating = (empty($bus->rating)) ? 'Has not been rated yet' : $bus->rating;
                    echo $rating;
                    ?></div>
                                <?php echo CHtml::link('Create Event', array("events/create/$bus->bizurl"), array('class'=>'statlink')); ?>        
                            </div>

                        </div>

                        <div class="fR">
                            <div class="top">Events<br>
                                <span class="green"><?php echo $bus->publicEventCount; ?></span></div>
                            <div class="btm"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook.png" alt="" width="16" height="16" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="" width="16" height="16" border="0"></a></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <?php
                    $index++;
                }
 ?>

<div class="paging">
<?php $this->widget('application.widgets.MoPager', array(
      'pages' => $pages,
      'cssFile'=> false,
      'header'=> false,
      'prevPageLabel'=>'← Previous',
      'nextPageLabel'=>'Next →',  
  )) ?>
</div>
</div>        