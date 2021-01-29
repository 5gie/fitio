<?php if ($this->js) : ?>
    <?php foreach (array_reverse($this->js) as $js) : ?>
        <script src="<?php echo $js ?>"></script>
    <?php endforeach ?>
<?php endif ?>