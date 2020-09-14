<?php
use App\Entity\Post;
use App\Connection;
use App\Validators\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Security\Auth;


Auth::check();
$pdo = Connection::getPDO();
$item = new Post();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$errors = [];

if(!empty($_POST)) {
    $itemTable = new PostTable($pdo);
    $v = new PostValidator($_POST, $itemTable, $item->getId(), $categories);
    $item->hydrate($_POST);

    if($v->validate()) {
        $pdo->beginTransaction();
        $itemTable->addPost($item);
        $itemTable->attachCategories($item->getId(), $_POST['categories_ids']);
        $pdo->commit();
        header('Location:' . $router->url('admin_post_edit', ['id' => $item->getId()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);
$title = 'Création d\'un article';

if (!empty($errors)) $message['error_create'] = true;
?>

<h1>Ajout d'article</h1>

<?php require('_form.php'); ?>
