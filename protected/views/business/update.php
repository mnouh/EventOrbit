<?php
$this->breadcrumbs=array(
	'Markers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Marker', 'url'=>array('index')),
	array('label'=>'Create Marker', 'url'=>array('create')),
	array('label'=>'View Marker', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Marker', 'url'=>array('admin')),
);
?>

<h1>Update Marker <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>