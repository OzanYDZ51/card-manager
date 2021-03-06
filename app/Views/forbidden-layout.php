<html>
    <head>
        <title>
            <?= $this->e($myTitle) ?>
        </title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/brands.css">
        <link rel="stylesheet" href="<?= $basePath ?>/assets/css/forbidden.css">
    </head>

    <body>
        <header> 
            <?php if ($isConnected): ?>
            <?= $this->insert('partials/navUserConnected'); ?>
            <?php else: ?>
            <?= $this->insert('partials/navUserNotConnected'); ?>
            <?php endif ?>
        </header>

        <main>

            <?= $this->section('content'); ?>
            
        </main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script src="<?= $basePath ?>/assets/js/app.js"></script>
        
        <?= $this->section('js'); ?>
        
    </body>
</html>