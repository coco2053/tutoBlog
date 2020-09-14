<?php
use App\Connection;
use App\Table\PostTable;
use App\Table\CategoryTable;
use App\Validators\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\Security\Auth;

Auth::check();

$pdo = Connection::getPDO();
$title = 'Editer un article';
$itemTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$item = $itemTable->find($params['id']);
$categoryTable->hydratePosts([$item]);
$errors = [];

$v = new PostValidator($_POST, $itemTable, $item->getId(), $categories);

if(!empty($_POST)) {
    $item->hydrate($_POST);
    if($v->validate()) {
        $pdo->beginTransaction();
        $itemTable->updatePost($item);
        $itemTable->attachCategories($item->getId(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$item]);
        $message['success_edit'] = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);

if (!empty($errors)) $message['error_edit'] = true;
?>

<h1>Editer l'article <?= e($item->getName()) ?></h1>

<?php require('_form.php'); ?>