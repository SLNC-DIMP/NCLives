<?php
$this->breadcrumbs=array(
	'Cdm Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CdmRecords', 'url'=>array('index')),
	array('label'=>'Manage CdmRecords', 'url'=>array('admin')),
);
?>

<h1>Create CdmRecords</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>