<?php
$this->breadcrumbs=array(
	'Records'=>array('index'),
	$model->Title,
);
/*
$this->menu=array(
	array('label'=>'List CdmRecords', 'url'=>array('index')),
	array('label'=>'Create CdmRecords', 'url'=>array('create')),
	array('label'=>'Update CdmRecords', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CdmRecords', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CdmRecords', 'url'=>array('admin')),
); */
$url = explode('/', $model->base_id);
?>

<h1><?php echo $model->Title; ?></h1>
<img src="http://cdm16062.contentdm.oclc.org/utils/getthumbnail/collection/<?php echo $url[0] . '/id/' . $url[1]; ?>" alt="<?php echo $model->Title; ?>">
<h3>Direct Item Link: <a href="<?php echo $model->Url; ?>">Click here to view item</a></h3>
<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Title',
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
