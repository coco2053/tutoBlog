
<?php if(isset($_GET['forbidden'])): ?>
    <?php if($_GET['forbidden']): ?>
        <div class="alert-danger">
            Vous ne pouvez pas accéder à cette page
        </div>
    <?php endif ?>
<?php endif ?>

<?php if(isset($_GET['logout'])): ?>
    <?php if($_GET['logout']): ?>
        <div class="alert-success">
            Vous avez été déconnecté
        </div>
    <?php endif ?>
<?php endif ?>
