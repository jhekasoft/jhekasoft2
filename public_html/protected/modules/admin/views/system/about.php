<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
	$this->module->id,
);
?>
<h1><?php echo Yii::t('app', 'About'); ?></h1>

<p>
    <strong><?php echo Yii::app()->getModule('revolute')->title; ?></strong>
</p>
<p>
    <?php echo Yii::t('app', 'Version'); ?>: <?php echo Yii::app()->getModule('revolute')->version; ?>
</p>