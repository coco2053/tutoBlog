<?php

use App\Connection;
use App\Table\PostTable;
use App\Security\Auth;

Auth::check();

$title = 'Administration des articles';
$pdo = Connection::getPDO();
list($items, $pagination) = (new PostTable($pdo))->findPaginated();

$link = $router->url('admin_posts');

?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Titre</th>
        <th scope="col">Extrait</th>
        <th scope="col">Catégories</th>
        <th scope="col"><a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Nouveau</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($items as $k => $item): ?>
        <tr>
            <th scope="row"><?= $k+1 ?></th>
            <td><?= e($item->getName()) ?></td>
            <td><?= $item->getExcerpt(40) ?></td>
            <td><?= !empty($item->getCategories()) ? implode(', ', $item->getCategories()) : 'Aucune' ?></td>
            <td>
                <a href="<?= $router->url('admin_post_edit', ['id' => $item->getId()]) ?>" class="btn btn-primary">Editer</a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $item->getId()]) ?>" method="post"
                    onsubmit="return confirm('Etes-vous sûre ?')" style="display:inline">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<div class="d-flex justify-content-between my-4">
    <?= $pagination->pagination($link) ?>
</div>
