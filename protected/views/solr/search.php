<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');

$this->pageTitle=Yii::app()->name . ' - Search results';
$this->breadcrumbs=array(
    'Search Results',
);
?>

<?php 
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'searchForm',
	'type'=>'search',
	'action' => 'search',
	'method' => 'get',
	'htmlOptions'=>array('class'=>'well'),
)); ?>
	
<input type="text" id="home_search" class="input-xxlarge search-query" name="q" value="" placeholder="Search NCLives!" />
<?php $this->widget('bootstrap.widgets.BootButton', array(
		'buttonType'=>'submit',
		'size'=>'large', 
		'icon'=>'search', 
		'label'=>'Search', 
		'htmlOptions' => array('value' => 'search')
	  )); ?>
</form>
<?php $this->endWidget(); ?>

<h1>Search Results for: "<?php echo CHtml::encode($term); ?>"</h1>

<?php 
if(!empty($results)) {
	foreach($results as $data) { ?>
    	<div class="view">
    	<?php echo CHtml::image(Yii::app()->request->baseUrl . '/' . $data->image_path, $data->Title, array('class'=>'gif_format')); ?>
    <br />
    
	<b><?php echo CHtml::encode('Title'); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Title), array('iaRecords/view','id'=>$data->id)); ?>
	<br />
 
	<b><?php echo CHtml::encode('Volume'); ?>:</b>
	<?php echo CHtml::encode($data->Volume); ?>
	<br />

	<b><?php echo CHtml::encode('Creator'); ?>:</b>
	<?php echo CHtml::encode($data->Creator); ?>
	<br />

	<b><?php echo CHtml::encode('Subject'); ?>:</b>
	<?php echo CHtml::encode($data->Subject); ?>
	<br />

	<b><?php echo CHtml::encode('Publisher'); ?>:</b>
	<?php echo CHtml::encode($data->Publisher); ?>
	<br />

	<b><?php echo CHtml::encode('Pub_Date'); ?>:</b>
	<?php echo CHtml::encode($data->Pub_Date); ?>
	<br />

	<b><?php echo CHtml::encode('Language'); ?>:</b>
	<?php echo CHtml::encode($data->Language); ?>
	<br />

	<b><?php echo CHtml::encode('Sponsor'); ?>:</b>
	<?php echo CHtml::encode($data->Sponsor); ?>
	<br />

	<b><?php echo CHtml::encode('Contributor'); ?>:</b>
	<?php echo CHtml::encode($data->Contributor); ?>
	<br />

	<b><?php echo CHtml::encode('MediaType'); ?>:</b>
	<?php echo CHtml::encode($data->MediaType); ?>
	<br />
<!--
	
-->
	<b>More Info: <a href="<?php //echo $data->url_link ?>">Click here to view item</a></b>
    <br />
	<br />
    <span id="viewOptions"><strong>Viewing Options:</strong></span>
	<ul id="viewItem">
    	<li><a target="_blank" href="http://archive.org/stream/<?php echo $data->base_id; ?>">Read Online</a></li>
        <li><a target="_blank" href="http://archive.org/download/<?php echo $data->base_id . '/' .$data->base_id; ?>.pdf">PDF</a></li>
        <li><a target="_blank" href="http://archive.org/stream/<?php echo $data->base_id . '/' .$data->base_id; ?>_djvu.txt">Full Text</a></li> 
        <li><a target="_blank" href="http://archive.org/download/<?php echo $data->base_id . '/' .$data->base_id; ?>.mobi">Kindle</a></li>      
    </ul>
    <br /><br />
    </div>
<?php    }
} else{ ?>
	<div class="alert alert-error">
		<strong>Sorry, but your query returned no results.</strong>
	</div>
    <?php
} ?>