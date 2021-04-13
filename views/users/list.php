<div class="container">
    <div class="form-page">
        <div class="list-users">
        
            <div class="heading">
                <h3>List users</h3>
            </div>

            <?php if($users): ?>
            <div class="panels">


                <?php foreach($users as $user): ?>

                    <div class="panel">
                    
                        <div class="image">
                            <?php if($user->data->image): ?>
                                <img src="<?php echo $user->data->image ?>" alt="<?php echo $user->data->name ?>">
                            <?php else: ?>
                                <i class="fal fa-camera"></i>
                            <?php endif ?>
                        </div>
                        <div class="content">
                            <h5><?php echo $user->data->name ?></h5>
                            <p><?php echo $user->data->content ?></p>
                            <?php if($user->rating): ?>
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <?php if ($i <= $user->rating) : ?>
                                            <i class="fas fa-star"></i>
                                        <?php else : ?>
                                            <i class="far fa-star"></i>
                                        <?php endif ?>
                                    <?php endfor ?>
                                </div>
                                <span class="rating"><?php echo $user->rating ?>/5</span>
                            <?php endif ?>
                            <a href="/profil/<?php echo $user->id ?>">Zobacz profil</a>
                        </div>

                    </div>

                <?php endforeach ?>



            </div>
            <?php endif ?>

        </div>

        <?php echo $paginator ?>
    </div>
</div>