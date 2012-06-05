<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');

$this->breadcrumbs=array(
	'Records'=>array('index'),
	$model->id,
);
/*
$this->menu=array(
	array('label'=>'List IaRecords','url'=>array('index')),
	array('label'=>'Create IaRecords','url'=>array('create')),
	array('label'=>'Update IaRecords','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete IaRecords','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage IaRecords','url'=>array('admin')),
); */
?>

<h1><?php echo $model->Title; ?></h1>
<?php echo CHtml::image(Yii::app()->request->baseUrl . '/' . $model->image_path, $model->Title, array('class'=>'gif_format')); ?>
<div>
<h3 id="viewOptions">Viewing Options:</h3>
	<ul id="viewItem">
    	<li><a target="_blank" href="http://archive.org/stream/<?php echo $model->base_id; ?>">Read Online</a></li>
        <li><a target="_blank" href="http://archive.org/download/<?php echo $model->base_id . '/' .$model->base_id; ?>.pdf">PDF</a></li>
        <li><a target="_blank" href="http://archive.org/stream/<?php echo $model->base_id . '/' .$model->base_id; ?>_djvu.txt">Full Text</a></li> 
        <li><a target="_blank" href="http://archive.org/download/<?php echo $model->base_id . '/' .$model->base_id; ?>.mobi">Kindle</a></li>      
    </ul>
</div>
<h3>Direct Item Link: <a href="<?php echo $model->url_link ?>">Click here to view item</a></h3>

<?php $this->widget('bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'url_link',
		'datestamp',
		'Title',
		'Volume',
		'Creator',
		'Subjects',
		'Publisher',
		'Pub_Date',
		'Language',
		'Sponsor',
		'Contributor',
		'MediaType',
	),
)); ?>
