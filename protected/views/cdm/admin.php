<?php
$this->breadcrumbs=array(
	'Cdms'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Cdm','url'=>array('index')),
	array('label'=>'Create Cdm','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cdm-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cdms</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.BootGridView',array(
	'id'=>'cdm-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'collection',
		'pointer',
		'Title',
		'Creator',
		'Item_Date',
		/*
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
			'class'=>'bootstrap.widgets.BootButtonColumn',
		),
	),
)); ?>
