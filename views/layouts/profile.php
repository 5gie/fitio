<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->title ?></title>

    <link rel="icon" type="image/png" href="fav.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{css}}
    <script src="//cdn.jsdelivr.net/npm/less@3.13"></script>
</head>

<body id="home">

    <?php if ($this->session->get('user')) : ?>
        <a class="btn btn-primary logout" href="/wyloguj">Wyloguj</a>
    <?php endif ?>

    {{alerts}}
    {{content}}

    {{javascript}}

</body>

</html>