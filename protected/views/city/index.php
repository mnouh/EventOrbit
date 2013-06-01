<section>
<div class="bannerMenu">
<div class="topbannerMenu">
  <ul>
    <li><a href="#">Find Events</a></li>
	<li><a href="#">Create Your Event</a></li>
    <li><a href="#">Learn More</a></li>
    <li><a href="#">Help  </a></li>
  </ul>
  </div>
  </div>
<div class="clear"></div>
<div class="eventDetails">
    <div class="leftFloat">
      <div class="headings">
        <h5 class="reviewHeading extra">Popular events in <?php echo $model->display_name;?>  </h5>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTl">
            
            <?php
             

    $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataEventsProvider,
    'itemView'=>'_events',   // refers to the partial view named '_post'
    'pagerCssClass' => 'page',
        'pager'=>array(
            'htmlOptions' => array('class' => 'pagings'),
	),
    //'cssFile'=> Yii::app()->baseUrl.'/styles/css.css',
    'sortableAttributes'=>array(
        'name',
        //'date_created'=>'Post Time',
        //'' => CHtml::link('Clear Filters', array('user/'.$model->lookup.'?Reviews_page=pager')),
    ),
));
    
    
?>
        </table>
        <div class="txtRht">
          <input name="Submit332222" type="submit" class="submitButtonAll" value="See All">
        </div>
      </div>
      <div class="headings padTop">
        <h5 class="reviewHeading extra">Popular Categories  </h5>
        <ul class="categories">
          <li><a href="#">Bars</a></li>
          <li><a href="#"> Hookah Bars</a></li>
          <li><a href="#"> Dance Clubs</a></li>
          <li><a href="#"> Karaoke</a></li>
          <li><a href="#"> Sports Bars</a> </li>
        </ul>
		<div class="clear"></div>
        <div class="txtRht">
          <input name="Submit3322222" type="submit" class="submitButtonAll" value="See All">
        </div>
      </div>
      <div class="headings padTop">
        <h5 class="reviewHeading extra"> Recently Added Events </h5>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mainTl">
          <tr>
            <td class="lft"><a href="#">National ShamrockFest 2012<br>
            </a></td>
            <td class="date">March 24 </td>
            <td><a href="#" class="button">Attend</a></td>
          </tr>
          <tr>
            <td class="lft"><a href="#">Houston Children's Festival</a></td>
            <td class="date">March 27 </td>
            <td><a href="#" class="button">Attend</a></td>
          </tr>
          <tr>
            <td class="lft"><a href="#">Chicago Beer Festival</a></td>
            <td class="date">April 6 </td>
            <td><a href="#" class="button">Attend</a></td>
          </tr>
          <tr>
            <td class="lft"><a href="#">Social Media &amp; Online Marketing Manager: Creating Blogging, Facebook, Twitter &amp; YouTube Strategies</a></td>
            <td class="date">April 11 </td>
            <td><a href="#" class="button">Attend</a></td>
          </tr>
          <tr>
            <td class="lft"><a href="#">OC Beer Festival</a></td>
            <td class="date">April 17 </td>
            <td><a href="#" class="button">Attend</a></td>
          </tr>
        </table>
        <div class="txtRht">
          <input name="Submit3322223" type="submit" class="submitButtonAll" value="See All">
        </div>
      </div>
    </div>
    <div class="rightFloat">
	<div class="blocks">
	<div class="headings"><strong>Talk of the Town </strong></div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
      <tr>
        <td><a href="#"><strong>Online Event Registration - Sell Tickets Online with EventOrbit </strong></a> <br>
          <em>77 People Attend This !! </em></td>
        <td width="70"><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>134 Reviews</em></td>
      </tr>
      <tr>
        <td><a href="#"><strong>Tour with NRG  - Charleston, SC</strong></a> <br>
          <em>19 People Attend This !! </em></td>
        <td><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
            <em>78 Reviews</em></td>
      </tr>
    </table>
	<div class="txtRht">
      <input name="Submit33222" type="submit" class="submitButtonAll" value="See All">
    </div>
	</div>
	<div class="blocks">
      <div class="headings"><strong>Reviewer of the day  </strong></div>
	  
	  <div class="reviewer"> <a href="#"><strong><img src="<?php echo Yii::app()->baseUrl;?>/images/member1-th.jpg" alt="" width="40" height="40">Good Trip to Ooty!!! </strong></a><br>
	    We were given rooms in the basement despite me requesting rooms on a higher floor. However the rooms we were given had great views and access to a garden. The rooms amd bathroom desperately needed to be updated and the floors were not clean. Couldn't walk barefoot in the rooms.service in the main restaurant was slow.
	    <div class="clear"></div></div>
	  <div class="reviewerBio"><strong><a href="#">Victoria Campbell</a></strong><br>
	  Toronto, Canada </div>
	</div>
	<div class="blocks">
      <div class="headings"><strong>Top Rated Business </strong></div>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
        <tr>
          <td><a href="#"><strong>89Bytes Web Studio </strong></a></td>
          <td width="70"><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
              <em>134 Reviews</em></td>
        </tr>
        <tr>
          <td><a href="#"><strong>Notes for Us </strong></a> <br></td>
          <td><span class="review"> <a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span><br>
              <em>78 Reviews</em></td>
        </tr>
      </table>
	  <div class="txtRht">
        <input name="Submit332223" type="submit" class="submitButtonAll" value="See All">
      </div>
	  </div>
    <div class="blocks">
      <div class="headings"><strong>New Business Just Added</strong></div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
        <tr>
          <td><a href="#"><strong>89Bytes Web Studio </strong></a></td>
          <td width="130" class="rhtTxt"><em>Added on March 26 </em></td>
        </tr>
        <tr>
          <td><a href="#"><strong>Notes for Us </strong></a> <br></td>
          <td class="rhtTxt"><em>Added on November 24</em></td>
        </tr>
        <tr>
          <td><a href="#"><strong>123webLogics</strong></a></td>
          <td class="rhtTxt"><em>Added on November 24</em></td>
        </tr>
      </table>
      <div class="txtRht">
        <input name="Submit3322232" type="submit" class="submitButtonAll" value="See All">
      </div>
    </div>
    </div>
    <div class="clear"></div>
  </div>
</section>