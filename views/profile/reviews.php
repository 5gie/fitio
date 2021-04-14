<div class="container">
    <div class="form-page">
        <h1>Profil <?php echo $user->id ?></h1>
        <?php if ($user->data) : ?>
            <?php $this->userImage($user->data->image) ?>
            <h1><?php echo $user->data->name ?></h1>
            <p><?php echo $user->data->content ?></p>
        <?php endif ?>
        <a href="/profil/<?php echo $user->id ?>/opinie/dodaj">Dodaj opinie</a>

        <?php if ($user->reviews) : ?>
            <?php foreach ($user->reviews as $review) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5><?php echo $review->user->data ? $review->user->data->name : $review->user->email ?></h5>
                        <p><?php echo $review->content ?></p>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <?php if ($i <= $review->rating) : ?>
                                <i class="fas fa-star"></i>
                            <?php else : ?>
                                <i class="far fa-star"></i>
                            <?php endif ?>
                        <?php endfor ?>
                        <span><?php echo $review->created_at ?></span>
                    </div>
                </div>

            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>