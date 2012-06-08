<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<div id="mainmenu">
		<?php $this->widget('bootstrap.widgets.BootNavbar', array(
			'fixed'=>false,
			'brand'=>Yii::app()->name,
			'brandUrl'=>Yii::app()->baseUrl,
			'collapse'=>true,
			'items'=>array(
				array(
					'class'=>'bootstrap.widgets.BootMenu',
					'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					//	array('label'=>'Browse', 'url'=>array('/search/browse')),
						array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					)
				), '<form class="navbar-search pull-left" action="' . Yii::app()->baseUrl .'/lucene/search">
					<input type="text" class="search-query span2" name="q" value="" placeholder="Search">
					<button type="submit" class="btn-small" label="submit"><i class="icon-search"></i>Search</button></form>',
			), 
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/footerncdcr75.png'), "http://www.ncdcr.gov/", array('target'=>'_blank')); ?>
    	<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/footerslnc75.png'), "http://statelibrary.ncdcr.gov/", array('target'=>'_blank')); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
