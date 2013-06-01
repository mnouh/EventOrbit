<?php
$this->breadcrumbs=array(
	'Markers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Marker', 'url'=>array('index')),
	array('label'=>'Create Marker', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('marker-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Markers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'marker-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'categories',
		'address',
		'address0',
		'address1',
		/*
		'address2',
		'address3',
		'phone',
		'display_phone',
		'lat',
		'lng',
		'postal_code',
		'country_code',
		'state_code',
		'city',
		'num_reviews',
		'rating',
		'neighborhoods',
		'bizurl',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
