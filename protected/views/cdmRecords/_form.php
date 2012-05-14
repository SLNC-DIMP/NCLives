<div class="form">

<?php $form=$this->beginWidget('BootstrapActiveForm', array(
	'id'=>'cdm-records-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'identifier'); ?>
		<?php echo $form->textField($model,'identifier',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identifier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'base_id'); ?>
		<?php echo $form->textField($model,'base_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'base_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datestamp'); ?>
		<?php echo $form->textField($model,'datestamp',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'datestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_link'); ?>
		<?php echo $form->textField($model,'url_link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Title'); ?>
		<?php echo $form->textField($model,'Title',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'Title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Creator'); ?>
		<?php echo $form->textField($model,'Creator',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Item_Date'); ?>
		<?php echo $form->textField($model,'Item_Date',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Item_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Time_Period'); ?>
		<?php echo $form->textField($model,'Time_Period',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Time_Period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Subjects'); ?>
		<?php echo $form->textField($model,'Subjects',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'Subjects'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Rights'); ?>
		<?php echo $form->textField($model,'Rights',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Rights'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Characteristics'); ?>
		<?php echo $form->textField($model,'Characteristics',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'Characteristics'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Formats'); ?>
		<?php echo $form->textField($model,'Formats',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Formats'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DCR_Collection'); ?>
		<?php echo $form->textField($model,'DCR_Collection',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'DCR_Collection'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Digital_Collection'); ?>
		<?php echo $form->textField($model,'Digital_Collection',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Digital_Collection'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Format'); ?>
		<?php echo $form->textField($model,'Format',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Audience'); ?>
		<?php echo $form->textField($model,'Audience',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'Audience'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Archival_Coll_Creator'); ?>
		<?php echo $form->textField($model,'Archival_Coll_Creator',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Archival_Coll_Creator'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Local'); ?>
		<?php echo $form->textField($model,'Local',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Local'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Type'); ?>
		<?php echo $form->textField($model,'Type',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'Type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Language'); ?>
		<?php echo $form->textField($model,'Language',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'Language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Themes'); ?>
		<?php echo $form->textField($model,'Themes',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'Themes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Url'); ?>
		<?php echo $form->textField($model,'Url',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'Url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Created'); ?>
		<?php echo $form->textField($model,'Created',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'Created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Modified'); ?>
		<?php echo $form->textField($model,'Modified',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'Modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->