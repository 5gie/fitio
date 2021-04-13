<div class="container">
    <div class="form-page">
        <h1>Lista wiadomości</h1>

        <?php if ($conversations) : ?>

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Last</th>
                            <th>Created</th>
                            <th class="text-right">Tools</th>
                        </tr>
                        <?php foreach ($conversations as $conversation) : ?>
                            <tr>
                                <td><?php echo $conversation->id ?></td>
                                <td><a href="/profile/<?php echo $conversation->user->id ?>"><?php echo $conversation->user->email ?></a></td>
                                <td><?php echo $conversation->message->content ?></td>
                                <td><?php echo $conversation->message->created_at ?></td>
                                <td><?php echo $conversation->created_at ?></td>
                                <td class="tools text-right">
                                    <a href="/konto/wiadomosci/<?php echo $conversation->id ?>"><i class="far fa-arrow-right"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div>

        <?php endif ?>
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