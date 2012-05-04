<?php $this->pageTitle=Yii::app()->name; ?>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Search NCLives!',
)); ?>
    <p>(Combining information from the Internet Archives and North Carolina Digital Collections)</p>
   <?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
		'id'=>'searchForm',
		'type'=>'search',
		'htmlOptions'=>array('class'=>'well'),
	)); ?>
	<?php // echo $form->textFieldRow($model, 'textField', array('class'=>'input-medium')); ?>
    <input type="text" id="home_search" class="input-xxlarge search-query" placeholder="Search NCLives!" />
	<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'size'=>'large', 'icon'=>'search', 'label'=>'Search')); ?>
	 </form>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>