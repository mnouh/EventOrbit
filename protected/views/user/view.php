<?php

$date = strtotime($model->joined_date);

$joined_date = date("l, F d, Y", $date);

?>
<section>
  <div class="evRev">
    <div class="topMenu">
      <ul>
        <li><a href="#" class="sel">Reviews</a></li>
        <li><?php echo CHtml::link('Events', array('user/events/'.$model->lookup)); ?></li>
        <li><a href="#">Statistics</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <div class="btm">
      <div class="leftFloat">
        <div class="profImg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-profile-img.jpg" alt=""></div>
        <div class="name"><?php echo $model->firstName.' '; echo substr($model->lastName, 0, 1).'.'; ?> </div>
        <div>Location: <?php echo $model->city.', '.$model->state;?></div>
        <div class="divider"><a href="#"><em>Total Reviews: <?php echo $model->reviewsCount;?> </em></a></div>
        <div>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="revTable">
            <tr>
              <td class="lft">5 Star </td>
              <td class="rht"><?php echo CHtml::link($model->reviewsCountFive.' Reviews', array('user/'.$model->lookup.'?rate=5')); ?></td>
            </tr>
            <tr>
              <td class="lft">4 Star </td>
              <td class="rht"><?php echo CHtml::link($model->reviewsCountFour.' Reviews', array('user/'.$model->lookup.'?rate=4')); ?></td>
            </tr>
            <tr>
              <td class="lft">3 Star </td>
              <td class="rht"><?php echo CHtml::link($model->reviewsCountThree.' Reviews', array('user/'.$model->lookup.'?rate=3')); ?></td>
            </tr>
            <tr>
              <td class="lft">2 Star </td>
              <td class="rht"><?php echo CHtml::link($model->reviewsCountTwo.' Reviews', array('user/'.$model->lookup.'?rate=2')); ?></td>
            </tr>
            <tr>
              <td class="lft">1 Star </td>
              <td class="rht"><?php echo CHtml::link($model->reviewsCountOne.' Reviews', array('user/'.$model->lookup.'?rate=1')); ?></td>
            </tr>
          </table>
            
            
            <div class="general divider" style="text-align:center;"><a href="#"><b>Statistics</b></a></div>
            <div>Joined Date:</div> <div id="space"><?php echo $joined_date;?></div>
            <div id="space"><strong><?php echo $model->eventsCount;?> Events Submitted</strong></div>
            <div id="space" class="name">Attending <?php echo $model->rsvpCount; ?> Events</div>
            <div id="space">Discussion Posts: <?php echo $model->discussionCount; ?></div>
            </div>
            
      </div>
      <div class="rightFloat">
        <h2>All Reviews </h2>
        <div>
            
             <?php
             
             
    $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'reviews',   // refers to the partial view named '_post'
    'pagerCssClass' => 'page',
        'pager'=>array(
            'htmlOptions' => array('class' => 'pagings'),
	),
    //'cssFile'=> Yii::app()->baseUrl.'/styles/css.css',
    'sortableAttributes'=>array(
        'rating',
        'date_created'=>'Post Time',
        '' => CHtml::link('Clear Filters', array('user/'.$model->lookup.'?Reviews_page=pager')),
    ),
));
    
    
       ?>
            
           
        <?php //$this->renderPartial('reviews', array('model' => $model)); ?>
            
        </div>
       
      </div>
      <div class="clear"></div>
    </div>
  </div>
</section>