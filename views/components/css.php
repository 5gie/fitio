<?php if ($this->css) : ?>
    <?php foreach ($this->css as $css) : ?>
        <link href="<?php echo $css['title'] ?>" rel="stylesheet<?php echo $css['type'] == 'less' ? '/less' : '' ?>" type="text/css" media="all">
    <?php endforeach ?>
<?php endif ?>