<?php
$this->breadcrumbs=array(
	'Cdm Records'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CdmRecords', 'url'=>array('index')),
	array('label'=>'Create CdmRecords', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cdm-records-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cdm Records</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cdm-records-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'identifier',
		'base_id',
		'datestamp',
		'url_link',
		'Title',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
