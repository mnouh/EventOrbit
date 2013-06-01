<?php 
$this->pageTitle=Yii::app()->name . ' - Find an Event'; 
$cs=Yii::app()->clientScript;  
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.watermarkinput.js', CClientScript::POS_HEAD);  
//$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.bar.custom.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/orbit.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyBYyogbtGgj4TloAVbB0MJC8o2JIrjwlvc&sensor=true', CClientScript::POS_HEAD);
?>


<?php $form=$this->beginWidget('CActiveForm', array(
        //'action'=>"search",
        //'method'=>'get',
        'id'=>'findparty-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>TRUE, 'validationDelay' => 100),
        //'htmlOptions'=>array('onSubmit'=>'return searchLocations()'),
)); ?>
          
<section>
<div class="top">discover events that orbit you</div>
<div class="bottom">
		
                <?php //echo $form->textField($model,'addressInput', array('class'=>'inputBox', 'autocomplete' => 'off')); ?>
    
    
    <?php
    
    echo $form->hiddenField($model, 'id', array('autocomplete' => 'off'));
// ext is a shortcut for application.extensions
$this->widget('ext.myAutoComplete', array(
    'id' => 'FindPartyForm_addressInput',
    'name' => 'FindPartyForm[addressInput]',
    'source' => $this->createUrl('city/autocomplete'),
// attribute_value is a custom property that returns the 
// name of our related object -ie return $model->related_model->name
    //'value' => $model->id,
    'options' => array(
        'minChars'=>3,
        'delay'=>100,
        //'minLength' => 2,
        'autoFill'=>false,
        //'scroll' => true,
        'focus'=> 'js:function( event, ui ) {
            $( "#FindPartyForm_addressInput" ).val( ui.item.name );
            return false;
        }',
        'select'=>'js:function( event, ui ) {
            $("#'.CHtml::activeId($model,'id').'")
            .val(ui.item.id);
            return false;
        }'
     ),
    'htmlOptions'=>array('class'=>'inputBox', 'autocomplete'=>'off'),
    'methodChain'=>'.data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.name +  "</a>" )
            .appendTo( ul );
    };'
));
?>
  
  
  <?php
	/*	echo CHtml::ajaxSubmitButton(
                                        'Find Event',
                                        array(''),
                                        array('success'=>'js:function(data) {
                                                    jQuery("div#status").html(data);
                                                    jQuery("div#load").removeClass("loading");
                                                    jQuery("div#main-map").show();      
                                               }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load").addClass("loading");}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {load();searchLocations();}',
                                                'type' => 'POST'
                                        ),
                                array('class'=> 'btn')
                                );
         * 
         */
  echo CHtml::submitButton('Find Event', array('name' => 'Submit', 'class' => 'btn'));
            ?>
  <div class="clear"></div>
  <?php echo $form->error($model,'addressInput', array('class'=>'error'));?>
</div>

<?php $this->endWidget(); ?>
</section>

    
  
    
    
          




