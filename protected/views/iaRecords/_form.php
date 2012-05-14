<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'ia-records-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'identifier',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'base_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'fulltext_available',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'url_link',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'datestamp',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'Title',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Volume',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Creator',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Subject',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Publisher',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Pub_Date',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Language',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Sponsor',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'Contributor',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'MediaType',array('class'=>'span5','maxlength'=>25)); ?>

	<?php echo $form->textFieldRow($model,'Updatedate',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
