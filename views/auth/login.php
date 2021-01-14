<?php 
use app\system\form\Form;
?>
<h1>Login</h1>
<?php $form = Form::begin('','POST') ?>

    <?php echo $form->inputField($model, 'email') ?>
    <?php echo $form->inputField($model, 'password')->passwordField() ?>

    <button type="submit" class="btn btn-primary">Submit</button>
<?php echo Form::end() ?>