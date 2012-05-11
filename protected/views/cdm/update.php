<?php
$this->breadcrumbs=array(
	'Cdms'=>array('index'),
	$model->Title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cdm','url'=>array('index')),
	array('label'=>'Create Cdm','url'=>array('create')),
	array('label'=>'View Cdm','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Cdm','url'=>array('admin')),
);
?>

<h1>Update Cdm <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>