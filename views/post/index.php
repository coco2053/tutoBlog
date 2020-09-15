<?php
use App\Connection;
use App\Table\PostTable;

$title = 'Mon Blog';
$pdo = Connection::getPDO();
list($items, $pagination) = (new PostTable($pdo))->findPaginated();

$link = $router->url('home');

?>
<h1>Mon Blog</h1>

<div class="row">
    <?php foreach($items as $item): ?>
    <div class="col-md-3">
        <?php require 'card.php'; ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->pagination($link) ?>
</div>