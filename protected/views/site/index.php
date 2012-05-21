<?php $this->pageTitle=Yii::app()->name; ?>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Search NCLives!',
)); ?>
    <p>(Combining information from the Internet Archives and North Carolina Digital Collections)</p>
   <?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
		'id'=>'searchForm',
		'type'=>'search',
		'action' => 'lucene/search',
		'method' => 'get',
		'htmlOptions'=>array('class'=>'well'),
	)); ?>
    <input type="text" id="home_search" class="input-xxlarge search-query" name="q" value="" placeholder="Search NCLives!" />
	<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'size'=>'large', 'icon'=>'search', 'label'=>'Search', 'htmlOptions' => array('value' => 'search'))); ?>
	 </form>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>