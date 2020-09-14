<form action="" method="POST">
    <?= $form->input('name', 'Nom'); ?>
    <?= $form->input('slug', 'Url'); ?>

    <button class="btn btn-primary">
        <?php if($item->getId() != null) : ?>
        Modifier
        <?php else: ?>
        Créer
        <?php endif ?>
    </button>
</form>
