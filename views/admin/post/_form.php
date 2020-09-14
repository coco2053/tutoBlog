<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'Url'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->select('categories_ids', 'Catégories', $categories); ?>
    <?= $form->input('created_at', 'Date de création'); ?>

    <button class="btn btn-primary">
        <?php if($item->getId() != null) : ?>
        Modifier
        <?php else: ?>
        Créer
        <?php endif ?>
    </button>
</form>
