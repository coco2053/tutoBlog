<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Security\Auth;

Auth::check();

$title = 'Administration des catégories';
$pdo = Connection::getPDO();
list($items, $pagination) = (new CategoryTable($pdo))->findPaginated();

$link = $router->url('admin_categories');

?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nom</th>
        <th scope="col">Url</th>
        <th scope="col"><a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouvelle catégorie</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($items as $k => $item): ?>
        <tr>
            <th scope="row"><?= $k+1 ?></th>
            <td><?= e($item->getName()) ?></td>
            <td><?= $item->getSlug() ?></td>
            <td>
                <a href="<?= $router->url('admin_category_edit', ['id' => $item->getId()]) ?>" class="btn btn-primary">Editer</a>
                <form action="<?= $router->url('admin_category_delete', ['id' => $item->getId()]) ?>" method="post"
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
