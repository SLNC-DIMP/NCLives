<?php
$this->breadcrumbs=array(
	'Records',
);
/*
$this->menu=array(
	array('label'=>'Create IaRecords','url'=>array('create')),
	array('label'=>'Manage IaRecords','url'=>array('admin')),
); */
?>

<h1>Record Listings</h1>

<?php $this->widget('bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
