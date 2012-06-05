<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');
?>
<div class="view">
	<?php if($data->table == 'ia_records'):
	     	 echo CHtml::image(Yii::app()->request->baseUrl . '/' . $data->image_path, $data->Title, array('class'=>'gif_format')); 
			 $view = 'iaRecords';
		  else:
			  $url = explode('/', $data->base_id); 
			  $view = 'cdmRecords';	  
	?>
	<img style="float:left; padding: 0 10px 10px 0" src="http://cdm16062.contentdm.oclc.org/utils/getthumbnail/collection/<?php echo $url[0] . '/id/' . $url[1]; ?>" alt="<?php echo $data->Title; ?>">
	<?php
		  endif;
	?>
    <br />
    
	<b><?php echo CHtml::encode('Title'); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Title),array($view . '/view','id'=>$data->page_id)); ?>
	<br />
 
	<b><?php echo CHtml::encode('Url'); ?>:</b>
	<?php echo CHtml::encode($data->url_link); ?>
	<br />

	<b><?php echo CHtml::encode('Creator'); ?>:</b>
	<?php echo CHtml::encode($data->Creator); ?>
	<br />

	<b><?php echo CHtml::encode('Subjects'); ?>:</b>
	<?php echo CHtml::encode($data->Subjects); ?>
	<br />
    
	<b>More Info: <a href="<?php echo $data->url_link ?>">Click here to view item</a></b>
    <br />
	<br />
   
    <br /><br />
    
</div>