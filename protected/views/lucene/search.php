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
  if(!empty($results)): 
		$this->widget('bootstrap.widgets.BootListView', array(
		'dataProvider'=>$results,
		'itemView'=>'_view',
	));  
	

  else: ?>
	<div class="alert alert-error">
		<strong>There are no entries matching your search.</strong>
	</div>
    <?php
endif; ?>