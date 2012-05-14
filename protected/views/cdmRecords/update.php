<?php
$this->breadcrumbs=array(
	'Cdm Records'=>array('index'),
	$model->Title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CdmRecords', 'url'=>array('index')),
	array('label'=>'Create CdmRecords', 'url'=>array('create')),
	array('label'=>'View CdmRecords', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CdmRecords', 'url'=>array('admin')),
);
?>

<h1>Update CdmRecords <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>