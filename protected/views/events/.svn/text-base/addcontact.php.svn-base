<div id="popupContact">
        <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>false,
)); ?>
        <a id="popupContactClose">x</a>  
        <h1>Create a new Contact</h1>  
        <p id="contactArea">
            <div class="clear"></div>
            <div class="floatLeft">Contact Name: &nbsp;&nbsp;</div>
            
            <?php echo $form->textField($contact,'contact_name',array('size'=>60,'maxlength'=>120, 'style' => 'width:180px')); ?>
            <?php echo $form->error($contact, 'contact_name');?>
            <div class="clear"></div>
            <div class="floatLeft">Contact Email: &nbsp;&nbsp;</div>
            <?php echo $form->textField($contact,'contact_email',array('size'=>60,'maxlength'=>120, 'style' => 'width:180px')); ?>
            <?php echo $form->error($contact, 'contact_email');?>
            <div class="contactButton">
                <?php
		echo CHtml::ajaxSubmitButton(
                                        'Add Contact',
                                        array('addcontact'),
                                        array('success'=>'js:function(data) {
                                                    jQuery("div#status").html(data);
                                               }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=> 'btn')
                                );
         
                ?>
            </div>
            <div id="contactstatus">
                &nbsp;
            </div>
        </p>  
    <?php $this->endWidget(); ?>
    </div>  
    <div id="backgroundPopup"></div>  