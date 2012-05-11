<?php
$this->breadcrumbs=array(
	'Cdms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cdm','url'=>array('index')),
	array('label'=>'Manage Cdm','url'=>array('admin')),
);
?>

<h1>Create Cdm</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>