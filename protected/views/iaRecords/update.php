<?php
$this->breadcrumbs=array(
	'Ia Records'=>array('index'),
	$model->Title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List IaRecords','url'=>array('index')),
	array('label'=>'Create IaRecords','url'=>array('create')),
	array('label'=>'View IaRecords','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage IaRecords','url'=>array('admin')),
);
?>

<h1>Update IaRecords <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>