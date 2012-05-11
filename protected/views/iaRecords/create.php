<?php
$this->breadcrumbs=array(
	'Ia Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List IaRecords','url'=>array('index')),
	array('label'=>'Manage IaRecords','url'=>array('admin')),
);
?>

<h1>Create IaRecords</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>