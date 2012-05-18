<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');

$this->pageTitle=Yii::app()->name . ' - Search results';
$this->breadcrumbs=array(
    'Search Results',
);
?>

   <?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
		'id'=>'searchForm',
		'type'=>'search',
		'action' => 'search',
		'method' => 'get',
		'htmlOptions'=>array('class'=>'well'),
	)); ?>
	<?php // echo $form->textFieldRow($model, 'textField', array('class'=>'input-medium')); ?>
    <input type="text" id="home_search" class="input-xxlarge search-query" name="q" value="" placeholder="Search NCLives!" />
	<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'size'=>'large', 'icon'=>'search', 'label'=>'Search', 'htmlOptions' => array('value' => 'search'))); ?>
	 </form>
	<?php $this->endWidget(); ?>

<h1>Search Results for: "<?php echo CHtml::encode($term); ?>"</h1>
<div class="view">
<?php if (!empty($results)): ?>
			<?php $this->widget('bootstrap.widgets.BootListView',array(
                'dataProvider'=>$results,
                'itemView'=>'_view',
            )); ?>
<?php else: ?>
     	<div class="alert alert-error">
        	<strong>Sorry, but no results matched your search query</strong>.
        </div>
<?php endif; ?>
</div>