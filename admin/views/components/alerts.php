<?php if ($this->session->get('flash')) : ?>
<div id="alerts">
    <?php foreach ($this->session->get('flash') as $type => $flash) : ?>
        <div class="alert alert-<?php echo $type ?>">
            <?php echo $this->session->getFlash($type) ?>
        </div>
    <?php endforeach ?>
</div>
<?php endif; ?>