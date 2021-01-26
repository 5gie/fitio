<?php

use app\system\App;
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->title ?></title>

    <link rel="icon" type="image/png" href="fav.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <?php if ($this->css) : ?>
        <?php foreach ($this->css as $css) : ?>
            <link href="<?php echo $css['title'] ?>" rel="stylesheet<?php echo $css['type'] == 'less' ? '/less' : '' ?>" type="text/css" media="all">
        <?php endforeach ?>
    <?php endif ?>
    <script src="//cdn.jsdelivr.net/npm/less@3.13"></script>
</head>

<body id="auth">

    <?php if ($this->session->getFlash('success')) : ?>
        <div class="alert alert-success">
            <?php echo $this->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    {{content}}

    <?php if ($this->js) : ?>
        <?php foreach (array_reverse($this->js) as $js) : ?>
            <script src="<?php echo $js ?>"></script>
        <?php endforeach ?>
    <?php endif ?>

</body>

</html>