<?php
$css = Yii::app()->getClientScript();
$css->registerCssFile(Yii::app()->baseUrl.'/css/item_view.css');
?>
<div class="view">
	<?php if($data->table == 'ia_records'):
	     	 echo CHtml::image(Yii::app()->request->baseUrl . '/' . $data->image_path, $data->Title, array('class'=>'gif_format')); 
			 $view = 'iaRecords';
			 $url_link = $data->url_link;
		  else:
			  $url = explode('/', $data->base_id); 
			  $view = 'cdmRecords';	  
			  $url_link = $data->Url;
	?>
	<img style="float:left; padding: 0 10px 10px 0" src="http://cdm16062.contentdm.oclc.org/utils/getthumbnail/collection/<?php echo $url[0] . '/id/' . $url[1]; ?>" alt="<?php echo $data->Title; ?>">
	<?php
		  endif;
	?>
    <br />
    
	<b><?php echo CHtml::encode('Title'); ?>:</b>
	<?php echo CHtml::link($data->Title,array($view . '/view','id'=>$data->page_id)); ?>
	<br />
 
	<b><?php echo CHtml::encode('Url'); ?>:</b>
	<?php echo $url_link; ?>
	<br />

	<b><?php echo CHtml::encode('Creator'); ?>:</b>
	<?php echo $data->Creator; ?>
	<br />

	<b><?php echo CHtml::encode('Subjects'); ?>:</b>
	<?php echo $data->Subjects; ?>
	<br />
    
	<b>More Info: <a href="<?php echo $url_link; ?>">Click here to view item</a></b>
    <br />
	<br />
   
    <br /><br />
    
</div>