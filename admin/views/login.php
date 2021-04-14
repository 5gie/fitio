<div class="container">
    <div class="login-page">
        <h1>Login</h1>
        <?php $formController = $this->form::begin('', 'POST') ?>

        <?php echo $formController->inputField($model, 'email') ?>
        <?php echo $formController->inputField($model, 'password')->passwordField() ?>

        <footer class="form-footer">
            <button type="submit" class="btn btn-primary">Zaloguj</button>
        </footer>
        <?php echo $this->form::end() ?>
    </div>
</div>