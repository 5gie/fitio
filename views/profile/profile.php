<div class="container">
    <div class="form-page">
        <h1>Profil <?php echo $user->id ?></h1>
        <?php if ($user->data) : ?>
            <?php $this->userImage($user->data->image) ?>
            <h1><?php echo $user->data->name ?></h1>
            <p><?php echo $user->data->content ?></p>
        <?php endif ?>
        <a href="/profil/<?php echo $user->id ?>/wiadomosc">Wyślij wiadomość</a>
        <br>
        <a href="/profil/<?php echo $user->id ?>/opinie">Opinie użytkownika</a>
    </div>
</div>