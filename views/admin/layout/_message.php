<?php if(isset($message['success_edit'])): ?>
    <?php if($message['success_edit']): ?>
        <div class="alert alert-success">
            L'entrée a bien été modifiée
        </div>
    <?php endif ?>
<?php endif ?>

<?php if(isset($_GET['created'])): ?>
    <?php if($_GET['created']): ?>
        <div class="alert alert-success">
            L'entrée a bien été enregistrée
        </div>
    <?php endif ?>
<?php endif ?>

<?php if(isset($_GET['delete'])): ?>
    <?php if($_GET['delete']): ?>
        <div class="alert alert-success">
            L'entrée a bien été supprimé
        </div>
    <?php endif ?>
<?php endif ?>

<?php if(isset($_GET['error_edit'])): ?>
    <?php if($_GET['error_edit']): ?>
        <div class="alert-danger">
            L'entrée n'a pas pu être modifié, merci de corriger vos erreurs
        </div>
    <?php endif ?>
<?php endif ?>

<?php if(isset($_GET['error_create'])): ?>
    <?php if($_GET['error_create']): ?>
        <div class="alert-danger">
            L'entrée n'a pas pu être enregistrée, merci de corriger vos erreurs
        </div>
    <?php endif ?>
<?php endif ?>