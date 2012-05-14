<?php
$this->breadcrumbs=array(
	'Cdm Records',
);
/*
$this->menu=array(
	array('label'=>'Create CdmRecords', 'url'=>array('create')),
	array('label'=>'Manage CdmRecords', 'url'=>array('admin')),
); */
?>

<h1>Cdm Records</h1>

<?php $this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
