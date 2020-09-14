<?php
use App\Connection;
use App\Table\CategoryTable;
use App\Validators\Validator;
use App\HTML\Form;
use App\Validators\CategoryValidator;
use App\Security\Auth;

Auth::check();

$pdo = Connection::getPDO();
$title = 'Editer une catégorie';
$itemTable = new CategoryTable($pdo);
$item = $itemTable->find($params['id']);
$errors = [];

Validator::lang('fr');
$v = new CategoryValidator($_POST, $itemTable, $item->getId());

if(!empty($_POST)) {

    $item->hydrate($_POST);
    if($v->validate()) {
        $itemTable->update([
                'name' => $item->getName(),
                'slug' => $item->getSlug()
        ], $item->getId());
        $message['success_edit'] = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);

if (!empty($errors)) $message['error_edit'] = true;
?>

<h1>Editer la catégorie <?= e($item->getName()) ?></h1>

<?php require('_form.php'); ?>