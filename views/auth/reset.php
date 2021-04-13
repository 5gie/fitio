<?php
use app\system\form\Form;
?>
<div class="container">
    <div class="form-page">
        <h1>Reset Hasła</h1>
        <?php $form = Form::begin('', 'POST') ?>

        <?php echo $form->inputField($model, 'email') ?>

        <footer class="form-footer">
            <button type="submit" class="btn btn-primary">Zarejestruj</button>
        </footer>
        <?php echo Form::end() ?>
    </div>
</div>
<style>
    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    h1 {
        color: #fff;
        font-size: 40px;
        margin-bottom: 30px;
    }

    .form-page {
        display: flex;
        justify-content: center;
        flex-direction: column;
        height: 100vh;
        align-items: center;
    }

    label {
        color: #fff;
    }

    form {
        min-width: 50%;
        background: rgba(255, 255, 255, 0.5);
        padding: 50px;
        box-shadow: 0px 0px 30px -3px rgba(0, 0, 0, 0.5);
    }
</style>