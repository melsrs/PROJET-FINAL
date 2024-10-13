<?php

include __DIR__ . '/../../Includes/header.php';
include __DIR__ . '/../../Includes/navbar.php';

?>

<div class="createArticle">
    <h2> Modifier la catégorie </h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container d-flex justify-content-center align-items-center">
        <form class="w-50" method="POST" action="<?= HOME_URL . 'dashboardAdmin/updateCategorie' ?>">
            <input type="hidden" name="Id_Categorie" value="<?= htmlspecialchars($categorie->getIdCategorie()) ?>">
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input type="text" name="image" class="form-control" id="image" value="<?= htmlspecialchars($categorie->getImage()) ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Nom</label>
                <input type="text" name="type" class="form-control" id="type" value="<?= htmlspecialchars($categorie->getType()) ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary my-3">Modifier</button>
            </div>
        </form>
    </div>