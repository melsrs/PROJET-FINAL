<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

?>

<div class="createArticle">
    <h2> Créer une catégorie </h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/createCategorie' ?>">
            <div class="mb-3 my-3">
                <label for="titre" class="form-label">Image</label>
                <input type="text" name="image" class="form-control" id="image" required>
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Créer une catégorie</button>
            </div>
        </form>
    </div>