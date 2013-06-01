<?php
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.rating.js', CClientScript::POS_HEAD);  

?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reviews-form',
	'enableAjaxValidation'=>true,
)); ?>
<section>
  <div class="eventDetails">
  <div class="leftFloat">
    <h5 class="reviewHeading">Complete Your Review:</h5>
    <div class="reviewSection">
      <h2><?php echo $business->name; ?> </h2>
      <div class="btm"><?php echo $business->address0;?>
        <?php echo $business->address1;?><br>
        <?php echo $business->address2;?><br>
        <?php echo $business->address3;?><br>
        <?php echo $business->display_phone;?>
      </div>
      <div class="review">
        <table width="100%" border="0" cellpadding="0" cellspacing="5">
          <tr>
            <td width="160"><strong>Rating :</strong></td>
            <td>
                <div style="height:30px;">    
    <?php echo $form->radioButtonList($model, 'rating', array(1=>'', 2 => '', 3=>'', 4=>'', 5=>''), array('class' =>'star'));?>
                </div>
        <?php
//<a class="revStar" href="#">1</a> <a class="revStar" href="#">2</a> <a class="revStar" href="#">3</a> <a class="revStar" href="#">4</a> <a class="revStar" href="#">5</a>
?>
            </td>
            <td><em>Roll over icons, then click to rate. </em></td>
          </tr>
          <tr>
            <td><strong>Your Review : </strong><br>
              <a href="#"><em>Read our review guidelines</em></a> </td>
            <td colspan="2">
                
            <?php echo $form->textArea($model, 'review', array('rows'=>8, 'class' => 'txtArea'));?>    
            
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><div class="txtRht">
                <input name="Submit3222" type="submit" class="submitButtonAll" value="Post">
                <input name="Submit3222" type="submit" class="submitButtonAll" value="Cancel">
            </div></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="rightFloat">
    <div class="blocks">
      <div class="headings"><strong>Reviews for this event </strong></div>
      <div class="paddTop">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="listT">
          <tr>
            <td><em>Jan 14</em><br>
<a href="#"><strong>David </strong></a>Says : <br>
              <a href="#"> I just wanted to say that I have joined the ranks of the Dan King/Edgewise Arts fans </a> </td>
            <td width="70"><span class="review"> <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span></td>
          </tr>
          <tr>
            <td><em>Jan 14</em><br>
<a href="#"><strong>Elena </strong></a>Says : <br>
              <a href="#"> I just wanted to say that I have joined the ranks of the Dan King/Edgewise Arts fans</a></td>
            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-none-sm.png" alt="" width="10" height="10" border="0"></a></span></td>
          </tr>
          <tr>
            <td><em>Jan 14</em><br>
<a href="#"><strong>Craig </strong></a>Says : <br>
              <a href="#"> I just wanted to say that I have joined the ranks of the Dan King/Edgewise Arts fans</a></td>
            <td><span class="review"> <a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-full-sm.png" alt="" width="10" height="10" border="0"></a><a href="#"><img src="<?php echo Yii::app()->baseUrl;?>/images/review-half-sm.png" alt="" width="10" height="10" border="0"></a></span></td>
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
<?php $this->endWidget(); ?>