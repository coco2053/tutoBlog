<?php
$categories = array_map(function($category) use ($router) {
    $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    return <<<HTML
<a href="{$url}">{$category->getName()}</a>
HTML;
}, $item->getCategories());

?>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlentities($item->getName()) ?></h5>
        <p class="text-muted">
            <?= $item->getCreatedAt()->format('d F Y') ?>
            <?php if(!empty($item->getCategories())): ?>
                ::
            <?= implode(', ', $categories) ?>
            <?php endif ?>
        </p>
        <p><?= $item->getExcerpt() ?> </p>
        <p>
            <a href="<?= $router->url('post', ['id' => $item->getId(), 'slug' => $item->getSlug()]) ?>" class="btn btn-primary">Voir plus</a>
        </p>
    </div>
</div>