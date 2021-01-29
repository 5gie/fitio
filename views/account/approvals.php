<?php

use app\system\form\Form;
?>
<div class="container">
    <div class="form-page">
        <h1>Register</h1>
        <?php $form = Form::begin('', 'POST') ?>

        <?php if ($model->registerApprovals) : ?>

            <?php foreach ($model->registerApprovals as $approval) : ?>
                <!-- TODO: $form->apprvoval -->
                <label>
                    <input type="checkbox" name="approvals[<?php echo $approval->id ?>]" <?php echo isset($model->approvals[$approval->id]) ? 'checked' : '' ?>>
                    <?php echo $approval->title ?>
                    <?php if ($approval->required == 1) : ?><span class="required">*</span> <?php endif ?>
                </label><br>

            <?php endforeach ?>

        <?php endif ?>

        <footer class="form-footer">
            <button type="submit" class="btn btn-primary">Zarejestruj</button>
            <span>Posiadasz już konto? <a class="text-light" href="/logowanie">Zaloguj się</a></span>
        </footer>
    </div>
</div>
<?php echo Form::end() ?>
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