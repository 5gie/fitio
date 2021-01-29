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

<body id="home">

    <?php if ($this->session->get('flash')) : ?>
        <?php foreach ($this->session->get('flash') as $type => $flash) : ?>
            <div class="alert alert-<?php echo $type ?>">
                <?php echo $this->session->getFlash($type) ?>
            </div>
        <?php endforeach ?>
    <?php endif; ?>

    {{content}}

    <?php if ($this->js) : ?>
        <?php foreach (array_reverse($this->js) as $js) : ?>
            <script src="<?php echo $js ?>"></script>
        <?php endforeach ?>
    <?php endif ?>

</body>

</html>