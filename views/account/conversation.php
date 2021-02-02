<?php

use app\system\form\Form;
?>
<div class="container">
    <div class="form-page">
        <h1>Konwersacja z użytkownikiem #<?php echo $sender->id !== $this->session->get('user') ? $sender->id : $recipient->id ?></h1>
        <div class="conversation-messages w-100">
            <?php foreach ($messages as $message) : ?>
                <div class="message card card-body bg-dark text-light mb-3 <?php echo $message->user_msg ? 'text-right ml-5' : 'mr-5' ?>">
                    <h5><?php echo $message->user_type == 'sender' ? $sender->email : $recipient->email ?></h5>
                    <span><?php echo $message->created_at ?></span>
                    <p><?php echo $message->content ?></p>
                </div>
            <?php endforeach ?>
        </div>
        <?php $form = Form::begin('', 'POST') ?>

        <?php echo $form->textareaField($model, 'content') ?>

        <footer class="form-footer">
            <button type="submit" class="btn btn-primary">Wyślij</button>
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