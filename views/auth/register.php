<?php 
use app\system\form\Form;
?>
<h1>Register</h1>
<?php $form = Form::begin('','POST') ?>

    <?php echo $form->inputField($model, 'name') ?>
    <?php echo $form->inputField($model, 'email') ?>
    <?php echo $form->inputField($model, 'password')->passwordField() ?>
    <?php echo $form->inputField($model, 'password2')->passwordField() ?>

    <button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end() ?>