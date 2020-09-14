<?php
use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$item = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$item]);
if($item->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $item->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}


$title = $item->getName();
?>

<h1><?= e($item->getName()) ?></h1>
<p class="text-muted"><?= $item->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($item->getCategories() as $k => $category): ?>
    <?php if($k > 0): ?>
    ,
    <?php endif ?>
    <a href="<?= $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]) ?>"><?= e($category->getName()) ?></a>
<?php endforeach ?>
<p><?= $item->getFormattedContent() ?> </p>


