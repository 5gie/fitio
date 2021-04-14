<?php foreach($this->actions as $action): ?>
    <?php if($action->type == 'button'): ?>
        <button class="btn <?php echo $action->classList ?>" id="<?php echo $action->id ?>" <?php echo $action->options ?>><?php echo $action->title ?></button>
    <?php else: ?>
        <a class="btn <?php echo $action->classList ?>" id="<?php echo $action->id ?>" <?php echo $action->options ?>><?php echo $action->title ?></a>
    <?php endif ?>
<?php endforeach ?>