<div class="view">
	<?php $url = explode('/', $data->base_id); ?>
	<img style="float:left; padding: 0 10px 10px 0" src="http://cdm16062.contentdm.oclc.org/utils/getthumbnail/collection/<?php echo $url[0] . '/id/' . $url[1]; ?>" alt="<?php echo $data->Title; ?>">
    <br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identifier')); ?>:</b>
	<?php echo CHtml::encode($data->identifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('base_id')); ?>:</b>
	<?php echo CHtml::encode($data->base_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datestamp')); ?>:</b>
	<?php echo CHtml::encode($data->datestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_link')); ?>:</b>
	<?php echo CHtml::encode($data->url_link); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('Title')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Title), array('view', 'id'=>$data->id)); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Creator')); ?>:</b>
	<?php echo CHtml::encode($data->Creator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Item_Date')); ?>:</b>
	<?php echo CHtml::encode($data->Item_Date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Time_Period')); ?>:</b>
	<?php echo CHtml::encode($data->Time_Period); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('Subjects')); ?>:</b>
	<?php echo CHtml::encode($data->Subjects); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Rights')); ?>:</b>
	<?php echo CHtml::encode($data->Rights); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Characteristics')); ?>:</b>
	<?php echo CHtml::encode($data->Characteristics); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Formats')); ?>:</b>
	<?php echo CHtml::encode($data->Formats); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('DCR_Collection')); ?>:</b>
	<?php echo CHtml::encode($data->DCR_Collection); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Digital_Collection')); ?>:</b>
	<?php echo CHtml::encode($data->Digital_Collection); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Format')); ?>:</b>
	<?php echo CHtml::encode($data->Format); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Audience')); ?>:</b>
	<?php echo CHtml::encode($data->Audience); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Archival_Coll_Creator')); ?>:</b>
	<?php echo CHtml::encode($data->Archival_Coll_Creator); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Local')); ?>:</b>
	<?php echo CHtml::encode($data->Local); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('Type')); ?>:</b>
	<?php echo CHtml::encode($data->Type); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Language')); ?>:</b>
	<?php echo CHtml::encode($data->Language); ?>
	<br />
-->
	<b><?php echo CHtml::encode($data->getAttributeLabel('Themes')); ?>:</b>
	<?php echo CHtml::encode($data->Themes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Url')); ?>:</b>
	<?php echo CHtml::encode($data->Url); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('Created')); ?>:</b>
	<?php echo CHtml::encode($data->Created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Modified')); ?>:</b>
	<?php echo CHtml::encode($data->Modified); ?>
	<br />
-->

</div>