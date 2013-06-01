<?php

$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/popup.js', CClientScript::POS_HEAD);  

?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); ?>
<section>
  <h3>Add Event at <?php echo $business->name;?>  </h3>
  <div class="signin">
    <div class="floatLeft">What  : </div>
    <div class="fR">
      <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>120)); ?>
      <?php echo $form->error($model,'name'); ?>
        
    </div>
 
    <div class="clear"></div>
    <div class="floatLeft">Where  : </div>
    <div class="fR">
   <?php //echo $form->textField($model,'name',array('size'=>60,'maxlength'=>120)); ?>
      <?php echo $form->error($model,'business_name'); ?>
        <?php $result[] = array('id' => $business->id, 'name' => $business->name); ?>
        <div class="row">
    <?php $this->widget('ext.tokeninput.TokenInput', array(
        'model' => $model,
        'attribute' => 'business_name',
        'url' => array('account/find'),
        //'value' => 'Terminal 5',
        'options' => array(
            'allowCreation' => false,
            'preventDuplicates' => true,
            'theme' => 'facebook',
            'prePopulate' => $result,
            'tokenLimit' => 1,
            //'propertyToSearch' => 'name',
        )
    )); ?>
      
    </div>
    </div>
    <div class="clear"></div>
    <div class="floatLeft">Guests  : </div>
    <div class="fR">
   <?php //echo $form->textField($model,'name',array('size'=>60,'maxlength'=>120)); ?>
      <?php echo $form->error($model,'guests'); ?>
        <?php //$result[] = array('id' => $business->id, 'name' => $business->name); ?>
        <div class="row">
    <?php $this->widget('ext.tokeninput.TokenInput', array(
        'model' => $model,
        'attribute' => 'guests',
        'url' => array('account/contacts'),
        //'value' => 'Terminal 5',
        'options' => array(
            'allowCreation' => true,
            'preventDuplicates' => true,
            'createTokenText'  => "(Create a new contact)",
            'resultsFormatter' => 'js:function(item){ return "<li>" + item.name + "<b><ul>" + item.email + "</ul></b></li>" }',
            'theme' => 'facebook',
            //'resultFormatter' => 'function(item){ return "<li>" Testing  "</li>" }',
            
            
            
        )
    )); ?>
            <div id="status">
                &nbsp;
            </div>
    </div>
    </div>
    <div class="clear"></div>
     
    
    
    <?php $this->renderPartial('addcontact', array('contact' => $contact), false); ?>
        

      
    
    
    
    <div class="floatLeft">Start Date : </div>
    <div class="fR">
        <?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        //'name' => CHtml::activeName($model, 'start_date'),
        'model'=>$model,
        'attribute' => 'start_date',
        'value' => $model->attributes['start_date'],
                    //'defaultOptions' => array('altFormat' => 'mm-dd-yy', 'dateFormat' => 'yy-mm-dd'),
        'options'=>array(
                'showAnim'=>'fold',
                'dateFormat' => 'mm-dd-yy',
                ),
        'htmlOptions'=>array(
                'style'=>'height:20px; width:80px;',

        ),
));
                ?>
    </div>
    <div class="clear"></div>
    <div class="floatLeft">Start Time : </div>
    <div class="fR">
    <?php echo $form->dropDownList($model, 'start_time',
                array(0 => '12:00 am', 30 => '12:30 am', 60 => '1:00 am', 
                    90 => '1:30 am', 120 => '2:00 am', 150 => '2:30 am', 180 => '3:00 am', 
                    210 => '3:30 am', 240 => '4:00 am', 270 => '4:30 am', 300 => '5:00 am', 
                    330 => '5:30 am', 360 => '6:00 am', 390 => '6:30 am', 420 => '7:00 am', 
                    450 => '7:30 am', 480 => '8:00 am', 510 => '8:30 am', 540 => '9:00 am', 
                    570 => '9:30 am', 600 => '10:00 am', 630 => '10:30 am', 660 => '11:00 am', 
                    690 => '11:30 am', 720 => '12:00 pm', 750 => '12:30 pm', 780 => '1:00 pm', 
                    810 => '1:30 pm', 840 => '2:00 pm', 870 => '2:30 pm', 900 => '3:00 pm', 
                    930 => '3:30 pm', 960 => '4:00 pm', 990 => '4:30 pm', 1020 => '5:00 pm', 
                    1050 => '5:30 pm', 1080 => '6:00 pm', 1110 => '6:30 pm', 1140 => '7:00 pm', 
                    1170 => '7:30 pm', 1200 => '8:00 pm', 1230 => '8:30 pm', 1260 => '9:00 pm', 
                    1290 => '9:30 pm', 1320 => '10:00 pm', 1350 => '10:30 pm', 1380 => '11:00 pm', 1410 => '11:30 pm'), array('options' => array(1020 => array('selected' => 'selected')))
            ); ?>

                <?php echo $form->error($model,'start_time'); ?>
    </div>
    <div class="clear"></div>
    <div class="floatLeft">End Date  : </div>
    <div class="fR">
      <?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => CHtml::activeName($model, 'end_date'),
        'model'=>$model,
        'attribute' => 'end_date',
        'value' => $model->attributes['end_date'],
                    //'defaultOptions' => array('altFormat' => 'mm-dd-yy', 'dateFormat' => 'yy-mm-dd'),
        'options'=>array(
                'showAnim'=>'fold',
                'dateFormat' => 'mm-dd-yy',
                ),
        'htmlOptions'=>array(
                'style'=>'height:20px; width:80px;',

        ),
));
                ?>
    </div>
    <div class="clear"></div>
    
    <div class="floatLeft">End Time  : </div>
    <div class="fR">
      <?php echo $form->dropDownList($model, 'end_time',
                array(0 => '12:00 am', 30 => '12:30 am', 60 => '1:00 am', 
                    90 => '1:30 am', 120 => '2:00 am', 150 => '2:30 am', 180 => '3:00 am', 
                    210 => '3:30 am', 240 => '4:00 am', 270 => '4:30 am', 300 => '5:00 am', 
                    330 => '5:30 am', 360 => '6:00 am', 390 => '6:30 am', 420 => '7:00 am', 
                    450 => '7:30 am', 480 => '8:00 am', 510 => '8:30 am', 540 => '9:00 am', 
                    570 => '9:30 am', 600 => '10:00 am', 630 => '10:30 am', 660 => '11:00 am', 
                    690 => '11:30 am', 720 => '12:00 pm', 750 => '12:30 pm', 780 => '1:00 pm', 
                    810 => '1:30 pm', 840 => '2:00 pm', 870 => '2:30 pm', 900 => '3:00 pm', 
                    930 => '3:30 pm', 960 => '4:00 pm', 990 => '4:30 pm', 1020 => '5:00 pm', 
                    1050 => '5:30 pm', 1080 => '6:00 pm', 1110 => '6:30 pm', 1140 => '7:00 pm', 
                    1170 => '7:30 pm', 1200 => '8:00 pm', 1230 => '8:30 pm', 1260 => '9:00 pm', 
                    1290 => '9:30 pm', 1320 => '10:00 pm', 1350 => '10:30 pm', 1380 => '11:00 pm', 1410 => '11:30 pm'), array('options' => array(1260 => array('selected' => 'selected')))
            ); ?>

                <?php echo $form->error($model,'end_time'); ?>
    </div>
    <div class="clear"></div>
    
    <div class="floatLeft">Description : </div>
    <div class="fR">
        <?php echo $form->textArea($model, 'details', array('rows' => '5'));?>
      <?php echo $form->error($model, 'details');?>
    </div>
    <div class="clear"></div>
    
    <div class="fR remember">
      <?php echo $form->checkBox($model, 'public', array('value' => '1'));?>
      <label for="remember"> Make this event public (anyone can see and join) </label>
    </div>
    <div class="clear"></div>
    
    <div class="fR remember">
      <?php echo $form->checkBox($model, 'guest_list_view', array('value' => '1'));?>
      <label for="remember"> Do not show the guest list on the event page </label>
    </div>
    <div class="clear"></div>
    <div class="fR">
      <input name="Submit3" type="submit" class="submitButton" value="Add Event">
    </div>
    <div class="clear"></div>
  </div>
</section>



<?php $this->endWidget(); ?>