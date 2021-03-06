<!doctype html>
<html lang="fr" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Bastien Vacherand">
    <title><?= isset($title) ? e($title) : 'Blog' ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="" class="navbar-brand">Mon site</a>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->url('admin_posts') ?>">Articles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->url('admin_categories') ?>">Catégories</a>
            </li>
            <li class="nav-item">
                <form action="<?= $router->url('logout') ?>" method="POST" style="display:inline">
                    <button type="submit" class="nav-link" style="background:transparent;border:none;">Se deconnecter</button>
                </form>
            </li>
        </ul>
    </nav>
        <div class="container mt-4">
            <?php require('_message.php') ?>
            <?= $content ?>

        </div>
<footer class="bg-light py-4 footer mt-auto">
    <div class="container">
        <?php if(defined('DEBUG_TIME')): ?>
        Page généréee en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
        <?php endif ?>
    </div>
</footer>
    </body>
</html>