<?php
use App\Entity\User;
use App\Table\UserTable;
use App\HTML\Form;
use App\Connection;

$user = new User();
$errors = [];

if(!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = "Identifiant ou mot de passe incorrect";
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connection::getPDO());
        try {
            $u = $table->findByUsername($_POST['username']);
            if(password_verify($_POST['password'], $u->getPassword()) == true) {
                session_start();
                $_SESSION['auth'] = $u->getId();
                header("Location: " . $router->url('admin_posts'));
                exit();
            }
        } catch (\App\Table\Exception\NotFoundException $e) {
        }
    }


}
$form = new Form($user, $errors);
?>
<h1>Se connecter</h1>

<form action="" method="POST">
    <?= $form->input('username', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>