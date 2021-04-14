<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Panel Administracyjny</title>

    <link rel="icon" type="image/png" href="fav.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{css}}
    <script src="//cdn.jsdelivr.net/npm/less@3.13"></script>
</head>

<body id="home">
    <div class="main-wrapper">
        {{alerts}}
        <div class="left-col">
            <header class="admin-header">
                <div class="logo">
                    <?php echo $this->image('logo.png', 'fitio') ?>
                </div>
                <div class="admin">
                    {{user}}
                </div>
            </header>
            <nav class="navbar">
                {{navbar}}
            </nav>
        </div>
        <div class="main-col">
            <div class="content-header">
                <div class="page-title">
                    <h1><?php echo $this->title ?></h1>
                </div>
                <div class="page-actions">
                    {{actions}}
                </div>
            </div>
            {{content}}
        </div>
    </div>
    {{javascript}}
</body>
</html>