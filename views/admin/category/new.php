<?php
use App\Connection;
use App\Validators\Validator;
use App\Validators\CategoryValidator;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Entity\Category;
use App\Security\Auth;

Auth::check();

$item = new Category();
$errors = [];

if(!empty($_POST)) {
    $pdo = Connection::getPDO();
    $itemTable = new CategoryTable($pdo);
    Validator::lang('fr');
    $v = new CategoryValidator($_POST, $itemTable, $item->getId());

    $item->hydrate($_POST);
    if($v->validate()) {
        $itemTable->add([
            'name' => $item->getName(),
            'slug' => $item->getSlug()
        ]);
        header('Location:' . $router->url('admin_category_edit', ['id' => $item->getId()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($item, $errors);
$title = 'Création d\'une catégorie';

if (!empty($errors)) $message['error_create'] = true;

?>

<h1>Ajout d'une catégorie</h1>

<?php require('_form.php'); ?>
