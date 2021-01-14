<h1>Contact</h1>
<?php 
use app\system\form\Form;
?>
<?php $form = Form::begin('', 'POST') ?>

<?php echo $form->inputField($model, 'title') ?>
<?php echo $form->inputField($model, 'email') ?>
<?php echo $form->textareaField($model, 'content') ?>

<button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end() ?>