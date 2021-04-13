<h1>Twoje opinie</h1>

<?php foreach ($reviews as $review) : ?>

    <div class="card mb-3">
        <div class="card-body">
            <h5><?php echo $review->user->email ?></h5>
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