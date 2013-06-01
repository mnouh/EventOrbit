<?php
$this->breadcrumbs=array(
	'Markers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Marker', 'url'=>array('index')),
	array('label'=>'Manage Marker', 'url'=>array('admin')),
);
?>

<h1>Create Marker</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>