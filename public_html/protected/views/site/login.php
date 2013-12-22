<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    //'layout' => BSHtml::FORM_LAYOUT_HORIZONTAL,
	'id' => 'login-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->textFieldControlGroup($model, 'username'); ?>

    <?php echo $form->passwordFieldControlGroup($model, 'password', array(
        'help' => 'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.'
    )); ?>

    <?php echo $form->checkBoxControlGroup($model,'rememberMe'); ?>

    <?php echo BSHtml::submitButton('Login', array(
        'color' => BSHtml::BUTTON_COLOR_PRIMARY
    )); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
