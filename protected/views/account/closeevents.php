<?php
             
             
    $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataEventsProvider,
    'itemView'=>'_test',   // refers to the partial view named '_post'
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