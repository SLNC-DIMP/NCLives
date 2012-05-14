<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');
?>
<div class="view">
	<?php echo CHtml::image(Yii::app()->request->baseUrl . '/' . $data->image_path, $data->Title, array('class'=>'gif_format')); ?>
<!--	<img style="float:left; padding: 0 10px 10px 0" src="http://archive.org/download/<?php echo $data->base_id . '/' . $data->base_id . '.gif'; ?>" alt="<?php echo $data->Title; ?>"> -->
    <br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('Title')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Title),array('view','id'=>$data->id)); ?>
	<br />
<!--	
    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('identifier')); ?>:</b>
	<?php echo CHtml::encode($data->identifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fulltext_available')); ?>:</b>
	<?php echo CHtml::encode($data->fulltext_available); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('url_link')); ?>:</b>
	<?php echo CHtml::encode($data->url_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datestamp')); ?>:</b>
	<?php echo CHtml::encode($data->datestamp); ?>
	<br />
 
	<b><?php echo CHtml::encode($data->getAttributeLabel('Volume')); ?>:</b>
	<?php echo CHtml::encode($data->Volume); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Creator')); ?>:</b>
	<?php echo CHtml::encode($data->Creator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Subject')); ?>:</b>
	<?php echo CHtml::encode($data->Subject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Publisher')); ?>:</b>
	<?php echo CHtml::encode($data->Publisher); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Pub_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Pub_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Language')); ?>:</b>
	<?php echo CHtml::encode($data->Language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sponsor')); ?>:</b>
	<?php echo CHtml::encode($data->Sponsor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Contributor')); ?>:</b>
	<?php echo CHtml::encode($data->Contributor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MediaType')); ?>:</b>
	<?php echo CHtml::encode($data->MediaType); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Updatedate')); ?>:</b>
	<?php  echo CHtml::encode($data->Updatedate); ?>
	<br />
-->

</div>