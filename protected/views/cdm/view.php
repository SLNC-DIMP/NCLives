<?php 
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');

$this->breadcrumbs=array(
	'Records'=>array('index'),
	$model->id,
);
/*
$this->menu=array(
	array('label'=>'List Cdm','url'=>array('index')),
	array('label'=>'Create Cdm','url'=>array('create')),
	array('label'=>'Update Cdm','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Cdm','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cdm','url'=>array('admin')),
); */
?>

<h1><?php echo $model->Title; ?></h1>

<img width="190" border="1" height="160" title="<?php echo $model->Title; ?>" src="http://digital.ncdcr.gov/cgi-bin/thumbnail.exe?CISOROOT=<?php echo $model->collection; ?>&amp;CISOPTR=<?php echo $model->pointer; ?>">

<h3>Direct Item Link: <a href="<?php echo $model->Url ?>">Click here to view item</a></h3>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'Creator',
		'Item_Date',
		'Time_Period',
		'Subjects',
		'Description',
		'Rights',
		'Characteristics',
		'Formats',
		'DCR_Collection',
		'Digital_Collection',
		'Format',
		'Audience',
		'Archival_Coll_Creator',
		'Local',
		'Type',
		'Language',
		'Themes',
		'Url',
		'Created',
		'Modified',
	),
)); ?>
