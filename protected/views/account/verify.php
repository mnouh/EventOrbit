<script type="text/javascript">
$(document).ready(function(){
    
    $("div.hidden").hide();
    $("div.hidden2").hide();
    $("input.btn#verify").hide();
    $("input.btn#resend").hide();
    $("p#verified").hide();
    
  $("a.btn#haveCode").click(function(){
    $("div.hidden").slideDown();
    $("input.btn#verify").show();
    $("a.btn#haveCode").hide();
    //$("input#VerifyForm_username").focus();
  });
  
  
  $("a.btn#needCode").click(function(){
    $("div.hidden2").slideDown();
    $("input.btn#resend").show();
    $("a.btn#needCode").hide();
    //$("input#VerifyForm_username").focus();
    
  });
  
  $("a.close#messageclose2").click(function(){
      
      $("div.hidden2").hide();
      $("input.btn#resend").hide();
      $("a.btn#needCode").show();
      
  });
  
  $("a.close#messageclose").click(function(){
      
      $("div.hidden").hide();
      $("input.btn#verify").hide();
      $("a.btn#haveCode").show();
      
  });
  
                                                
  
});
</script>
<?php


Yii::app()->clientScript->registerScript('helloscript',
        
        '
        
        function changeButton(){
                $("a.btn#needCode").hide();
                $("input.btn#verify").hide();
                $("div.hidden").hide();
                $("p#verified").show();
                
        }
        
        function formSend(form, data, hasError)
        {
                if(!hasError){
                        alert(data);
                }
        }

        
        
        '

        //"alert('jjjjjjjj');"
        ,CClientScript::POS_READY);

?>

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'verify-form',
	'enableAjaxValidation'=>true,
        //'focus' => array($model,'username'),
        //'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        'clientOptions'=>array(
            'validateOnSubmit'=>TRUE,
           //'validateOnSubmit'=>true,
           // 'validateOnChange'=>false,
           // 'validateOnType'=>false,
            
            ),
)); ?>
<p id="update_info">&nbsp;</p>
<div class="form" id="customForm" class="sync">

<div class="well">
    <div class="container-12" id="features">
     <div class="container-12" id="info">
      <h2>
        Account Verification
      </h2><a name="info">&nbsp;</a>
      <div class="col-6 alpha">
        <h3>
          Learn Together
        </h3>
        <p>
          
          School can be tough. Especially with bad notes and bad time management. Notes For Us, allows you to connect with other students
          in your class. Share and discuss notes. We have created a learning environment online that allows
          you to connect in every way imaginable with your classmates. 
          
        </p>
        
            
            <div class="hidden">
                <a id="messageclose" class="close" style="margin-right: 100px;">×</a>
                
                <?php
                if(isset($_GET['email'])) {
                echo $form->textField($model,'username', array ('class' => 'sync', 'value' => $_GET['email'], 'style'=>'visibility:hidden;'));    
                    
                }
                
                else {
                    echo $form->label($model,'username', array ('for'=> 'name', 'class' => 'sync'));
                    echo $form->textField($model,'username', array ('class' => 'sync', 'style'=>'display:block;'));    
                }
            ?>
                <?php echo $form->label($model,'verify_code', array ('for'=> 'name', 'class' => 'sync')); ?>
                <?php echo $form->textField($model,'verify_code', array ('class' => 'sync', 'style'=>'display:block;')); ?>    
                <div id="spaceless"></div>
                <div>
                <?php echo $form->error($model,'verify_code'); ?>
                </div>
                <div>
                <?php echo $form->error($model,'username'); ?>
                </div>
                <?php echo $form->errorSummary($model);?>
            </div>
                
        <div id="spaceLess1"></div>
                <div>
                    <a id ="haveCode" class="btn success">Have Code?</a>
                </div>
                    <div id="load">
                
                        
                        <?php //echo CHtml::submitButton('Verify Account', array('name' => 'Submit', 'class' => 'btn primary', 'id' => 'verify'));  
                        
                        
                        echo CHtml::ajaxSubmitButton(
                                        'Verify Account',
                                        array(''),
                                        array(
                                                'success' => 'function() {$("div#load").removeClass("loading"); }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load").addClass("loading"); }',
                                                //'validated' => 'function() {changeButton();}',
                                                //'complete' => 'function() {changeButton();}',
                                                'type' => 'POST'
                                            //changeButton();
                                        ),
                                array('class'=> 'btn primary', 'id' => 'verify')
                                );
                        ?>
                </div>
      </div>
                
      <div class="col-6">
        <h3>
          Sell your books
        </h3>
        <p>
          Have books sitting around in your closet? Why sell your books back to the book store? 
          Cut the middleman, let us connect you with school mates that would like to buy your book.
          This way you will earn more money, and save on shipping costs.
        </p>
        <div id="spaceLess"></div>
        <div id="spaceLess2"></div>
        <div class="hidden2">
            
                <a id="messageclose2" class="close" style="margin-right: 100px;">×</a>
                <?php
               
                    echo $form->label($resend,'email', array ('for'=> 'name', 'class' => 'sync'));
                    echo $form->textField($resend,'email', array ('class' => 'sync', 'style'=>'display:block;'));    
                
            ?>
                <div id="spaceless"></div>
                <div>
                <?php echo $form->error($resend,'email'); ?>
                </div>
            </div>
        
        <a class="btn" id="needCode">Resend Code</a>
        
        <div id="load1">
                
                        
                        <?php //echo CHtml::submitButton('Verify Account', array('name' => 'Submit', 'class' => 'btn primary', 'id' => 'verify'));  
                        
                        
                        echo CHtml::ajaxSubmitButton(
                                        'Resend Code',
                                        array(),
                                        array(
                                                'success'=>'function() {$("div#load1").removeClass("loading"); }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load1").addClass("loading"); }',
                                                //'validated' => 'function() {changeButton();}',
                                                //'complete' => 'function() {changeButton();}',
                                                'type' => 'POST'
                                            //changeButton();
                                        ),
                                array('class'=> 'btn primary', 'id' => 'resend', 'type' => 'submit')
                                );
                        ?>
                </div>
        
      </div>
    </div>
    </div>
    <div id="clear"></div>
    <div id="space"></div>
    
<div id="space"></div>
<div id="space"></div>
<div id="space"></div>
<div id="space"></div>

<div id="space"></div>
<div id="space"></div>
<div id="space"></div>

<div id="space"></div>

<div id="space"></div>
<div id="spaceLess1"></div>
    
</div>
    

</div>

<?php $this->endWidget(); ?>
